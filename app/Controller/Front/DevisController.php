<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\ProjectSubsectorModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\ProjectModel;

class DevisController extends Controller
{
	/**
	 * Liste des devis du professionnel
	*/
	public function list()
	{
		//Si le professionnel n'est pas connecté , il est redirigé sur la page de login
		if (empty($this->getUser())) {
			$this->redirectToRoute('front_provider_login');
		}

		$zip_code = null;
		$sub_sector = null;
		$projectModel = new ProjectModel();

		$projects = $projectModel->findAllDetailWithoutClosed($zip_code, $sub_sector);

		$this->show('front/devis_list', ['projects' => $projects]);	
	}

	/**
	 * Ajout d'un devis par un professionnel
	 * @param $id integer Correspond a l'id de la table ProjectSubsector
	*/
	public function add($id)
	{
		if(!is_numeric($id) || empty($id)){
			$this->showNotFound();
		}
		else
		{
			//Recherche du projet, de la catégorie et sous catégorie rattaché
			$projectSubsectorModel = new ProjectSubsectorModel(); 
			$projectSubsector = $projectSubsectorModel->findWithProjectAndSectorAndSubsector($id); 
			$this->show('front/devis_add', ['projectSubsector' => $projectSubsector]);
		}
	}
	


}



