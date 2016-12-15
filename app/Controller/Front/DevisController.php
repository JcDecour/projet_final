<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\ProjectModel;

class DevisController extends Controller
{
	/**
		* Page de déconnexion
	*/
	public function list()
	{
		// si le professionnel n'est pas connecté , il est redirigé sur la page de login
		if (empty($this->getUser())) {
			
			$this->redirectToRoute('front_provider_login');
		}


		$this->show('front/devis_list');	
	}


	public function add($idProjet)
	{
		if(!is_numeric($idProjet) || empty($idProjet)){
			$this->showNotFound();
		}
		else
		{
			$projetModel = new projectModel(); 
			$projet = $projetModel->find($idProjet); // $id correspond à l'id en URL
	
			$this->show('front/devis_add', ['projet' => $projet]);
		}
	}
	


}



