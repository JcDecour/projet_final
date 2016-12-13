<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\SectorModel;
use \Model\SubSectorModel;
use \Model\ProjectModel;
use \Model\ProjectSubSectorModel;
use \W\Security\AuthorizationModel;
use \Respect\Validation\Validator as v; 

class ServicesController extends Controller
{
	/**
	 * Page d'ajout d'une demande de service ou de projet par un particulier
	 */
	public function add()
	{
		//Soumission du formulaire
		$post = [];
		$formErrors = [];
		if(!empty($_POST)){

			//Nettoyage de la super globale $_POST
			foreach ($_POST as $key => $value) {
				if($key !== 'tabSsCateg'){
					$post[$key] = trim(strip_tags($value));
				}
				else{
					$post[$key] = $value;
				}
			}

			//Zip_code
			if(!v::notEmpty()->length(5, 5)->validate($post['zip_code'])){
				$formErrors['zip_code'] = 'Le code postal doit comporter 5 caractères.';
			}

			//Title
			if(!v::notEmpty()->length(10, 80)->validate($post['title'])){
				$formErrors['title'] = 'L\'objet du service doit comporter au moins 10 caractères.';
			}

			//Description
			if(!v::notEmpty()->length(20, null)->validate($post['description'])){
				$formErrors['description'] = 'Le descriptif du service doit comporter au moins 20 caractères.';
			}

			//Date prévisonnelle
			if(preg_match("#^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$#", $post['predicted_date']))
		    {
		      	$tabDate = explode("/", $post['predicted_date']);
		      	if(!checkdate($tabDate[1], $tabDate[0], $tabDate[2])){
		      		$formErrors['predicted_date'] = 'La date prévisionnelle est invalide.';
		      		//Vérifier que la date est supérieure à la date du jour
		      	}
		    }
		    else{
		    	$formErrors['predicted_date'] = 'La date prévisionnelle est invalide.';
		    }

		    //Cas du client qui n'est pas connecté
		    if(array_key_exists('email', $post)){
			    //Email
			    if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
			    	$formErrors['email'] = 'La format de l\'email est invalide.';
			    }

			   	//Mot de passe
				if(!v::notEmpty()->length(8, 20)->validate($post['password'])){
					$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères.';
				}
		    }

		    //Si aucune erreur de saisie, enregistrement des données en BDD
		    if(count($formErrors) === 0){
		    	//Insertion du service en BDD 
		    	$data = [
		    		'id_customer'		=> '1', //A modifier ultérieurement
		    		'zip_code'			=> $post['zip_code'],
		    		'title'				=> $post['title'],
		    		'description'		=> $post['description'],
		    		'predicted_date'	=> $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0],
		    		'created_at'		=> date('Y-m-d H:i:s'),
		    		'updated_at'		=> date('Y-m-d H:i:s'),
		    	];
				$projectModel = new ProjectModel();
				$project = $projectModel->insert($data);

				if($project){
					//Insertion des sous catégories du service en BDD
					$projectSubSectorModel = new ProjectSubsectorModel();
					foreach ($post['tabSsCateg'] as $key => $value) {
						$dataProjectSsSector = [
							'id_project'	=>	$project['id'],
							'id_subsector'	=>	$value,
							'created_at'	=> date('Y-m-d H:i:s'),
						];
						$projectSubSector = $projectSubSectorModel->insert($dataProjectSsSector);
					}
					$this->redirectToRoute('front_service_list_services');
				}
				else{
					$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';
				}
			}
		}

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Reconstruction des ss_sector
		$contenuSsSector = '';
		if(isset($post['tabSsCateg'])){
			$subSectorModel = new SubSectorModel();

			foreach ($post['tabSsCateg'] as $key => $value) {
				$subSectorResult = $subSectorModel->find($value);
				$sectorResult = $sectorModel->find($subSectorResult['id_sector']);


				$contenuSsSector .= '<div>'.$sectorResult['title'].' - '.$subSectorResult['title'].'<input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/><a href="#" class="remove_ss_categ_button"> Supprimer</a></div>';	
			}
		}

		$this->show('front/service_add', ['post' => $post, 'sectors' => $sectors, 'formErrors' => $formErrors, 'contenuSsSector' => $contenuSsSector]);
	}

	/**
	 * Affichera la liste des services ou projets par client
	 */
	public function list_services()
	{	

		// si le client n'est pas connecté je le redirige 
		if (!empty($this->getUser())) {
			
			$this->redirectToRoute('front_customer_login');
		}

		// On récupère les infos du client connecté
		$customer = $this->getUser();
		// On instancie le model pour communiquer avec la BDD
		$projectModel = new ProjectModel();

		//On récupère la liste des projets correspondant au client connecté
		$projects = $projectModel->findServiceById($customer['id']);

		return $projects;
			
		$this->show('front/service/list_services', ['projects' => $projects]);
	}

}