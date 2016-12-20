<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\ProviderModel;
use \Model\TokenModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\DevisModel;
use \PHPMailer;
use \Respect\Validation\Validator as v;

class ProviderController extends Controller
{
	public function devis($id)
	{
		if(!is_numeric($id) || empty($id)){
			$this->showNotFound();

		}
			else
			{
			$devis = new DevisModel(); 
				$devis = $DevisModel->find($id); // $id correspond à l'id en URL


				// Permet de gérer l'affichage
				$data = [
					'user' => $user, // $user vient du find() juste au dessus :-)
					'hello'	=> 'Bonjour tout le monde',
				];
		$this->show('front/provider_devis', $demande);
		}
	}

	public function signin()
	{	
		$user = $this->getUser();
		
		// si connecté je le redirige 
		if (isset($user)){
			
			$this->redirectToRoute('front_default_index');
		}

		$providerModel = new ProviderModel(); // appel de la fonction insert 
		$formErrors =[];//stockage des erreurs
		$passwordHash = new AuthentificationModel(); // appel de la fonction hashPassword
		$post = [];
			

		if(!empty($_POST)){

			$post=array_map('trim', array_map('strip_tags', $_POST));

			if(!v::notEmpty()->length(5, 80)->validate($post['company_name'])){
				$formErrors['company_name'] = 'La raison sociale doit comporter 5 caractères minimun';
			}

			if(!v::notEmpty()->length(3, null)->validate($post['company_description'])){
				$formErrors['company_description'] = 'La description doit comporter 3 caractères minimum';
			}

			if(!v::notEmpty()->digit()->length(14,14)->validate($post['siret'])){
				$formErrors['siret'] = 'Le n°siret doit contenir 14 chiffres';
			}

			if(!v::notEmpty()->length(3, 15)->validate($post['firstname'])){
				$formErrors['firstname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->length(3, 15)->validate($post['lastname'])){
				$formErrors['lastname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}

			if($providerModel->emailExists($post['email'])){
				$formErrors['email'] = 'L\'adresse email est déjà utilisée';
			}

			if(!v::notEmpty()->length(8,20)->validate($post['password'])){
				$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères';
			}

			if(!v::notEmpty()->digit()->length(10,10)->validate($post['fixed_phone'])){
				$formErrors['fixed_phone'] = 'Le téléphone fixe est invalide';
			}

			if(!v::notEmpty()->digit()->length(10,10)->validate($post['mobile_phone'])){
				$formErrors['mobile_phone'] = 'Le téléphone mobile est invalide';
			}

			if(!v::notEmpty()->length(8, 80)->validate($post['street'])){
				$formErrors['street'] = 'L\'adresse doit comporter entre 8 et 80 caractères';
			}

			if(!v::notEmpty()->digit()->length(5,5)->validate($post['zipcode'])){
				$formErrors['zipcode'] = 'Le code postal est invalide';
			}

			if(!v::notEmpty()->length(3, 80)->validate($post['city'])){
				$formErrors['city'] = 'La ville doit comporter entre 3 et 80 caractères';
			}

			if(count($formErrors) ===  0){

				$createProvider = [
					'company_name'  => $post['company_name'],
					'company_description'  => $post['company_description'],
					'siret'  => $post['siret'],
					'civilite'  => $post['civilite'],
					'firstname'  => $post['firstname'],
					'lastname'  => $post['lastname'],
					'email'  => $post['email'],
					'password'  => $passwordHash->hashPassword($post['password']),
					'fixed_phone'  => $post['fixed_phone'],
					'mobile_phone'  => $post['mobile_phone'],
					'street'  => $post['street'],
					'zipcode'  => $post['zipcode'],
					'city'  => $post['city'],
					'created_at' => date('Y-m-d H:i:s'),
					// 'updated_at' => date('Y-m-d H:i:s'),
				];
				if($providerModel->insert($createProvider)){
					// si l'utilisateur a été bien été créer ont stock un message de reussite dans $_SESSION et on redirige vers la page de connexion
					$_SESSION = [ 'formValid' => 'Votre profil a bien été créer, veuillez vous connecter.'];
					$this->redirectToRoute('front_provider_login');
						

				}

			}
			else{
				$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';

			}

		}
		$this->show('front/provider_signin', ['formErrors'=>$formErrors, 'post' => $post]);
	}
	/**
	 * Page de connexion
	 */
	public function login()
	{

		$error = null;
		if (!empty($_POST)) {
			$post = array_map('trim', array_map('strip_tags', $_POST));

			if (empty($post['email']) && empty($post['password'])) {
				$error = 'Identifiant ou mot de passe invalide';
			}
			else {
				// l'utilisateur a bien rempli un mdp et un email
				$providerModel = new ProviderModel();
				$idProvider = $providerModel->isValidLoginInfo($post['email'], $post['password']);

				// on a un id utilisateur
				if ($idProvider) {
					$provider = $providerModel->find($idProvider); // on récupère l'utilisateur

					// Connecte l'utilisateur et peuple la session
					$authModel = new AuthentificationModel();
					$authModel->logUserIn($provider);
				}
				else {
					// $idCustomer est égal à 0
					$error = 'Identifiant ou mot de passe invalide.';
				}
			}
		}

		// getUser() récupère l'utilisateur connecté
		// si l'utilisateur est connecté, je le redirige
		// Je le sors du !empty($_POST) pour que la redirection soit effective si un utilisateur déja connecté arrive sur le formulaire de connexion
		if (!empty($this->getUser())) {

			$this->redirectToRoute('front_devis_list');
		}



		$this->show('front/provider_login', ['error' => $error]);
	}

	/**
		* Page de déconnexion
	*/
	public function logout()
	{	
		$post = [];
		$post = array_map('trim', array_map('strip_tags', $_POST));

		if (isset($post['disconnect']) && !empty($post['disconnect'])) {
			
			if($post['disconnect'] === 'yes'){

				$authentificationModel = new AuthentificationModel();
				$authentificationModel->logUserOut();

				$this->redirectToRoute('front_default_index');
			}
			elseif ($post['disconnect'] === 'no') {
				
				$this->redirectToRoute('front_list_services');
			}
		}

		$this->show('front/customer_logout');
	}

	/**
		* Page du principe de fonctionnement du site pour le professionnel
	*/
	public function help()
	{	


		$this->show('front/provider_help');
	}

	/*
		* Mettra a jour les information du professionel connecté
	*/
	public function edit()
	{

		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || !isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}

		$provider = $this->getUser(); // récupère les info de l'utilisateur connecté$
		$providerModel = new ProviderModel(); // appel de la fonction update
		$formErrors =[];//stockage des erreurs
		$passwordHash = new AuthentificationModel(); // appel de la fonction hashPassword
		$updatePassword = false; // false si le champs password n'a pas été renseigné true si oui
		$formValid = []; // contiendra mon message de réussite
		
		if(!empty($_POST)){

			$post=array_map('trim', array_map('strip_tags', $_POST));

			if(!v::notEmpty()->length(5, 80)->validate($post['company_name'])){
				$formErrors['company_name'] = 'La raison sociale doit comporter 5 caractères minimun';
			}

			if(!v::notEmpty()->length(3, null)->validate($post['company_description'])){
				$formErrors['company_description'] = 'La description doit comporter 3 caractères minimum';
			}

			if(!v::notEmpty()->digit()->length(14,14)->validate($post['siret'])){
				$formErrors['siret'] = 'Le n° siret est invalide';
			}

			if(!v::notEmpty()->length(3, 15)->validate($post['firstname'])){
				$formErrors['firstname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->length(3, 15)->validate($post['lastname'])){
				$formErrors['lastname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}

			if(!empty($post['password'])){
				$updatePassword = true;

				if(!v::notEmpty()->length(8,20)->validate($post['password'])){
					$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères';
				}
			}

			if(!v::notEmpty()->digit()->length(10,10)->validate($post['fixed_phone'])){
				$formErrors['fixed_phone'] = 'Le téléphone fixe est invalide';
			}

			if(!v::notEmpty()->digit()->length(10,10)->validate($post['mobile_phone'])){
				$formErrors['mobile_phone'] = 'Le téléphone mobile est invalide';
			}

			if(!v::notEmpty()->length(8, 80)->validate($post['street'])){
				$formErrors['street'] = 'L\'adresse doit comporter entre 8 et 80 caractères';
			}

			if(!v::notEmpty()->digit()->length(5,5)->validate($post['zipcode'])){
				$formErrors['zipcode'] = 'Le code postal est invalide';
			}

			if(!v::notEmpty()->length(3, 80)->validate($post['city'])){
				$formErrors['city'] = 'La ville doit comporter entre 3 et 80 caractères';
			}

			if(count($formErrors) ===  0){

				$updateProvider = [
					'company_name'  => $post['company_name'],
					'company_description'  => $post['company_description'],
					'siret'  => $post['siret'],
					'civilite'  => $post['civilite'],
					'firstname'  => $post['firstname'],
					'lastname'  => $post['lastname'],
					'email'  => $post['email'],
					'fixed_phone'  => $post['fixed_phone'],
					'mobile_phone'  => $post['mobile_phone'],
					'street'  => $post['street'],
					'zipcode'  => $post['zipcode'],
					'city'  => $post['city'],
					'updated_at' => date('Y-m-d H:i:s'),
				];

				if($updatePassword){
					$updateProvider['password'] = $passwordHash->hashPassword($post['password']);
				}

				$provider = $providerModel->update($updateProvider, $provider['id']);

				// si les info on été mise a jours ont affiche un message de réussite

				if($provider){
					$formValid = ['valid' => 'Votre profil a bien été modifier'];
					//update des infos stocké en SESSION
					unset($_SESSION['user']);
					$_SESSION['user'] = $provider;
				}
			}		
			else{
				$forErrors['global'] = 'Erreur lors de la mise a jour du profil.';
			}
		}			
		$this->show('front/provider_profil', ['formErrors' => $formErrors, 'provider' => $provider, 'formValid' => $formValid]);
	}


	/*
	 * fonction pour gérer le mot de passe oublié
	*/
	public function pwdForget()
	{	
		$post = [];
		$formErrors =[];
		$formValid = [];

		$providerModel = new ProviderModel();
		$tokenModel = new TokenModel();

		if (!empty($_POST)) {
			
			$post= array_map('trim', array_map('strip_tags', $_POST));

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}
			if (!$providerModel->emailExists(($post['email']))) {
    			$formErrors['email'] = 'L\'email saisi est inconnu.';
   			}

   			if (count($formErrors) === 0) {
   				
   				//Génération du token
        		$token = hash('sha256', uniqid(rand(), true));

        		$data =[
        			'email' => $post['email'],
        			'token' => $token,
        		];

        		// Insertion dans la table token
   				$tokenModel->insert($data);

   				// Récupération de l'adresse du site
		            $domaineName = $_SERVER['HTTP_HOST'].$_SERVER['W_BASE'];
		            $sujet = "Réinitialisation de votre mot de passe";
		            $content = '<p>Bonjour,<br><br><a href="'.$domaineName.'/provider/pwd-reset?token='.$token.'">Cliquez sur ce lien pour réinitialiser votre mot de passe</a></p>'; 

		            $dest = $post['email'];
		         
		            //Envoie d'un email
				    $mail = new PHPMailer;
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'ssl0.ovh.net';  					  // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = 'devirama-not-reply@alloitech.com';           // SMTP username
					$mail->Password = 'devisrama';                       // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to
					
					$mail->CharSet = 'UTF-8';							  //Encodage en utf8 pour les problèmes d'accents

					$mail->setFrom('contact@devirama.com');
					$mail->addAddress($dest, 'EAL WF3');     			  // Add a recipient

					$mail->Subject = $sujet;
					$mail->Body    = $content;							  //Pour tous les messages (Peuvent contenir du HTML)
					$mail->AltBody = $content;							  //Pour tous les messages  SANS HTML

					// Envoi 
					if ($mail->send()) {
						$formValid = [ 'valid' => 'Vous allez recevoir un email pour reinitialiser votre mot de passe'];
					}
					else {
						var_dump( 'Erreur : ' . $mail->ErrorInfo);						
					}
   			}
   	
		}

			$this->show('front/provider_pwd-forget', ['formErrors' => $formErrors, 'formValid' => $formValid]);
 
	}
	

	/*
	 * fonction pour réinitialiser un mot de passe
	*/
	public function pwdReset()
	{	

		$get = [];
		$post = [];
		$formErrors =[];
		$formValid = [];

		$providerModel = new ProviderModel();
		$tokenModel = new TokenModel();
		$authentificationModel = new AuthentificationModel();

		if (!empty($_GET)) {
			
			if (!empty($_POST)) {
				
				$post = array_map('trim', array_map('strip_tags', $_POST)); 

				if(!v::stringType()->length(8,20)->validate($post['password'])){
					$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères';
				}
				if($post['password'] !== $post['password_confirm']){
	    	 		$formErrors['password_confirm'] = 'Erreur de confirmation de mot de passe.';
	    		}

	    		if (count($formErrors) === 0) {
	    			
	    			if (!empty($_GET['token'])) {
	    				
	    				$get = array_map('trim', array_map('strip_tags', $_GET));

	    				$token = $tokenModel->findByToken($get['token']);

	    				if ($token) {
	    					
		    				if ($providerModel->emailExists(($token['email']))) {

		    						$hashPassword = $authentificationModel->hashPassword($post['password']);

		    						$providerModel->updateByEmail(['password' => $hashPassword], $token['email']);
		    						
		    						$formValid = [ 'valid' => 'Votre mot de passe a été réinitialisé avec succès'];	 

	   						}
	    				}

	    			}
	    		}

			}
		}

		$this->show('front/provider_pwd-reset', ['formErrors' => $formErrors, 'formValid' => $formValid]);
	}


}