<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\CustomerModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Respect\Validation\Validator as v; 
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
					$_SESSION = [ 'formValid' => 'Votre profil a bien été créer, veuillez vous connecter.'];
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
					$formValid = [ 'valid' => 'Votre profil a bien été modifier'];	
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

}