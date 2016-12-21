<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\CustomerModel;
use \Model\TokenModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Respect\Validation\Validator as v; 
use \PHPMailer;
class CustomerController extends Controller
{

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
				$customerModel = new CustomerModel();
				$idCustomer = $customerModel->isValidLoginInfo($post['email'], $post['password']);

				// on a un id utilisateur
				if ($idCustomer) {
					$customer = $customerModel->find($idCustomer); // on récupère l'utilisateur

					// Connecte l'utilisateur et peuple la session
					$authModel = new AuthentificationModel();
					$authModel->logUserIn($customer);
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
			
			$this->redirectToRoute('front_list_services');
		}

		$this->show('front/customer_login', ['error' => $error]);
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
		* Page du principe de fonctionnement du site pour le particulier
	*/
	public function help()
	{	


		$this->show('front/customer_help');
	}

	/*
	*Page d'inscription particulier
	*
	*/
	public function signin()
	{	
		$user = $this->getUser();
		
		// si le client est connecté en compte pro je le redirige 
		if (isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
		
		$customerModel = new CustomerModel(); // appel de la fonction insert 
		$formErrors =[];//stockage des erreurs
		$passwordHash = new AuthentificationModel(); // appel de la fonction hashPassword
		$post = [];

		if(!empty($_POST)){

			$post= array_map('trim', array_map('strip_tags', $_POST));



			if(!v::notEmpty()->length(3, 15)->validate($post['firstname'])){
				$formErrors['firstname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->length(3, 15)->validate($post['lastname'])){
				$formErrors['lastname'] = 'Le prénom doit comporter entre 3 et 15 caractères';
			}

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}

			if($customerModel->emailExists($post['email'])){
				$formErrors['email'] = 'L\'adresse email est déjà utilisée';
			}

			if(!v::notEmpty()->length(8,20)->validate($post['password'])){
				$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères';
			}

			if(!empty($post['fixed_phone'])){
				if(!v::notEmpty()->digit()->length(10,10)->validate($post['fixed_phone'])){
					$formErrors['fixed_phone'] = 'Le téléphone fixe est invalide';
				}
			}

			if(!empty($post['mobile_phone'])){
				if(!v::notEmpty()->digit()->length(10,10)->validate($post['mobile_phone'])){
					$formErrors['mobile_phone'] = 'Le téléphone mobile est invalide';
				}
			}	

			if(!empty($post['street'])){
				if(!v::notEmpty()->length(8, 80)->validate($post['street'])){
					$formErrors['street'] = 'L\'adresse doit comporter entre 8 et 80 caractères';
				}
			}	

			if(!empty($post['zipcode'])){
				if(!v::notEmpty()->digit()->length(5,5)->validate($post['zipcode'])){
					$formErrors['zipcode'] = 'Le code postal est invalide';
				}
			}
			if(!empty($post['city'])){	
				if(!v::notEmpty()->length(3, 80)->validate($post['city'])){
					$formErrors['city'] = 'La ville doit comporter entre 3 et 80 caractères';
				}
			}

			if(count($formErrors) === 0){

				$createCustomer = [
					'civilite' => $post['civilite'],
					'firstname'  => $post['firstname'],
					'lastname'  => $post['lastname'],
					'email'  => $post['email'],
					'password'  => $passwordHash->hashPassword($post['password']),
					'fixed_phone' => $post['fixed_phone'],
					'mobile_phone' => $post['mobile_phone'],
					'street' => $post['street'],
					'zipcode' => $post['zipcode'],
					'city'	=> $post['city'],
					'created_at' => date('Y-m-d H:i:s'),
					// 'updated_at' => date('Y-m-d H:i:s'), envoie du'une date de mise a jour 
				];
				if($customerModel->insert($createCustomer)){
					// si l'utilisateur a été bien été créer ont stock un message de reussite dans $_SESSION et on redirige vers la page de connexion
					$_SESSION = [ 'formValid' => 'Votre profil a bien été créé, veuillez vous connecter.'];
					$this->redirectToRoute('front_customer_login');
					
				}

			}
			else{
				$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';
				
			}

		}

		$this->show('front/customer_signin', ['formErrors'=>$formErrors, 'post'=>$post]);
	}
	/*
	*mettra a jour les infos de l'utilisateur connecté
	*
	*/
	public function edit()
	{
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
		
		$customerModel = new CustomerModel(); // appel de la fonction update
		$formErrors =[];//stockage des erreurs
		$passwordHash = new AuthentificationModel(); // appel de la fonction hashPassword
		$customer = $this->getUser(); // récupère les info de l'utilisateur connecté
		$updatePassword = false; // false si le champs password n'a pas été renseigné true si oui
		$formValid = []; // contiendra mon message de réussite

		if(!empty($_POST)){

			$post= array_map('trim', array_map('strip_tags', $_POST));



			if(!v::notEmpty()->length(3, 25)->validate($post['firstname'])){
				$formErrors['firstname'] = 'Le prénom doit comporter entre 3 et 25 caractères';
			}

			if(!v::notEmpty()->length(3, 25)->validate($post['lastname'])){
				$formErrors['lastname'] = 'Le nom doit comporter entre 3 et 25 caractères';
			}

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}

			if(!empty($post['password'])){
				$updatePassword = true;

				if(!v::stringType()->length(8,20)->validate($post['password'])){
					$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères';
				}
			}

			if(!empty($post['fixed_phone'])){
				if(!v::notEmpty()->digit()->length(10,10)->validate($post['fixed_phone'])){
					$formErrors['fixed_phone'] = 'Le téléphone fixe est invalide';
				}
			}

			if(!empty($post['mobile_phone'])){
				if(!v::notEmpty()->digit()->length(10,10)->validate($post['mobile_phone'])){
					$formErrors['mobile_phone'] = 'Le téléphone mobile est invalide';
				}
			}	

			if(!empty($post['street'])){
				if(!v::notEmpty()->length(8, 80)->validate($post['street'])){
					$formErrors['street'] = 'L\'adresse doit comporter entre 8 et 80 caractères';
				}
			}	

			if(!empty($post['zipcode'])){
				if(!v::notEmpty()->digit()->length(5,5)->validate($post['zipcode'])){
					$formErrors['zipcode'] = 'Le code postal est invalide';
				}
			}
			if(!empty($post['city'])){	
				if(!v::notEmpty()->length(3, 80)->validate($post['city'])){
					$formErrors['city'] = 'La ville doit comporter entre 3 et 80 caractères';
				}
			}

			if(count($formErrors) === 0){

				$updateCustomer = [
					'civilite' => $post['civilite'],
					'firstname'  => $post['firstname'],
					'lastname'  => $post['lastname'],
					'email'  => $post['email'],
					'fixed_phone' => $post['fixed_phone'],
					'mobile_phone' => $post['mobile_phone'],
					'street' => $post['street'],
					'zipcode' => $post['zipcode'],
					'city'	=> $post['city'],
					'updated_at' => date('Y-m-d H:i:s'),
				];

				if($updatePassword){
					$updateCustomer['password'] = $passwordHash->hashPassword($post['password']) ;
				}

				$customer = $customerModel->update($updateCustomer, $customer['id']);
				if($customer){
					//si ok message de réussite
					$formValid = [ 'valid' => 'Votre profil a bien été modifié'];	
					// je refresh mes info de session avec les info stocke en bdd
					unset($_SESSION['user']);
					$_SESSION['user'] = $customer;



				}
		
			}
			else{
				$formErrors['global'] = 'Erreur lors de la mise a jour du profil.';
			}
		
		}
		
		$this->show('front/customer_profil', ['customer' => $customer, 'formErrors' => $formErrors, 'formValid' => $formValid]);
	}

	/*
	 * fonction pour gérer le mot de passe oublié
	*/
	public function pwdForget()
	{	
		$post = [];
		$formErrors =[];
		$formValid = [];

		$customerModel = new CustomerModel();
		$tokenModel = new TokenModel();

		if (!empty($_POST)) {
			
			$post= array_map('trim', array_map('strip_tags', $_POST));

			if(!v::notEmpty()->email()->validate($post['email'])){
				$formErrors['email'] = 'L\'adresse email saisie est invalide';
			}
			if (!$customerModel->emailExists(($post['email']))) {
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
		            /*$domaineName = $_SERVER['HTTP_HOST'].$_SERVER['W_BASE'];*/
		            $domaineName = $adresse = "http://".$_SERVER['SERVER_NAME'].$_SERVER['W_BASE'];
		            $sujet = "Réinitialisation de votre mot de passe";
		            $content = '<p>Bonjour,<br><br><a href="'.$domaineName.'/customer/pwd-reset?token='.$token.'">Cliquez sur ce lien pour réinitialiser votre mot de passe</a></p>'; 

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

			$this->show('front/customer_pwd-forget', ['formErrors' => $formErrors, 'formValid' => $formValid]);
 
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

		$customerModel = new CustomerModel();
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
	    					
		    				if ($customerModel->emailExists(($token['email']))) {

		    						$hashPassword = $authentificationModel->hashPassword($post['password']);

		    						$customerModel->updateByEmail(['password' => $hashPassword], $token['email']);
		    						
		    						$formValid = [ 'valid' => 'Votre mot de passe a été réinitialisé'];	    						
	   						}
	    				}

	    			}
	    		}

			}
		}

		$this->show('front/customer_pwd-reset', ['formErrors' => $formErrors, 'formValid' => $formValid]);
	}

}