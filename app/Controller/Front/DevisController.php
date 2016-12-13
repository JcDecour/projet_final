<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\CustomerModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\DevisModel;

class DevisController extends Controller
{
	public function devisProf($id)
	{
		if(!is_numeric($id) || empty($id)){
			$this->showNotFound();

		}
		$demande = new DevisModel(); 
			$demande = $usersModel->find($id); // $id correspond à l'id en URL


			// Permet de gérer l'affichage
			$data = [
				'user' => $user, // $user vient du find() juste au dessus :-)
				'hello'	=> 'Bonjour tout le monde',
			];
		$this->show('front/devis_prof');
	}
}



