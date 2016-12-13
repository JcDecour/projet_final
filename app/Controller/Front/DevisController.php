<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\ProjectModel;

class DevisController extends Controller
{
	public function add($idProjet)
	{
		if(!is_numeric($idProjet) || empty($idProjet)){
			$this->showNotFound();

		}
		else
		{
		$projetModel = new projectModel(); 
			$projet = $projetModel->find($idProjet); // $id correspond à l'id en URL

			$projet=[
				'test' => 'hello',
			];
			
			
		$this->show('front/devis_add', $projet);
	}
}

}

