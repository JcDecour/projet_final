<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\ProviderModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\DevisModel;
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

		$providerModel = new ProviderModel(); // appel de la fonction insert 
		$formErrors =[];//stockage des erreurs
		$passwordHash = new AuthentificationModel(); // appel de la fonction hashPassword
		$formValid = 'l\' inscription est un succès';
			

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

			if(!v::notEmpty()->length(8, 15)->validate($post['street'])){
				$formErrors['street'] = 'L\'adresse doit comporter entre 8 et 15 caractères';
			}

			if(!v::notEmpty()->digit()->length(5,5)->validate($post['zipcode'])){
				$formErrors['zipcode'] = 'Le code postal est invalide';
			}

			if(!v::notEmpty()->length(4, 15)->validate($post['city'])){
				$formErrors['city'] = 'La ville doit comporter entre 4 et 15 caractères';
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

					$this->redirectToRoute('front_customer_login', ['formValid'=>$formValid]);
						

				}

			}
			else{
				$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';

			}

		}
		$this->show('front/provider_signin', ['formErrors'=>$formErrors]);
	}

}
