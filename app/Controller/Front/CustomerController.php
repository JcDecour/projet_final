<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\CustomerModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;

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
				$error = 'Vous devez compléter votre identifiant et mot de passe pour vous connecter';
			}
			else {
				// l'utilisateur a bien rempli un mdp et un email
				$authModel = new AuthentificationModel();
				$idCustomer = $authModel->isValidLoginInfo($post['email'], $post['password']);

				// on a un id utilisateur
				if ($idCustomer) {
					$customerModel = new CustomerModel();
					$customer = $customerModel->find($idCustomer); // on récupère l'utilisateur

					// Connecte l'utilisateur et peuple la session
					$authModel->logUserIn($customer);
				}
				else {
					// $idCustomer est égal à 0
					$error = 'Identifiant ou mot de passe invalid !';
				}
			}
		}

		// getUser() récupère l'utilisateur connecté
		// si l'utilisateur est connecté, je le redirige
		// Je le sors du !empty($_POST) pour que la redirection soit effective si un utilisateur déja connecté arrive sur le formulaire de connexion
		if (!empty($this->getUser())) {
			
			$this->redirectToRoute('list_projects');
		}

		$this->show('front/customer_login', ['error' => $error]);
	}

}

