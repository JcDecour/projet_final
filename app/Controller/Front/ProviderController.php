<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\CustomerModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\DevisModel;

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
}



