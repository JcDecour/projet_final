<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \W\Model\ConnectionModel;
use \Model\SectorModel;
use \Model\ProjectModel;
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
		      	var_dump($tabDate);
		      	if(!checkdate($tabDate[1], $tabDate[0], $tabDate[2])){
		      		$formErrors['predicted_date'] = 'La date prévisionnelle est invalide.';
		      		//Vérifier que la date est supérieure à la date du jour
		      	}
		    }
		    else{
		    	$formErrors['predicted_date'] = 'La date prévisionnelle est invalide.';
		    }

		    //Email
		    if(!array_key_exists('email', $post) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
		    	$formErrors['email'] = 'La format de l\'email est invalide.';
		    }

		   
		    if(count($formErrors) === 0){

				

			}



		}

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Il faut alimenter le CP de la demande de devis avec par défaut le CP (s'il existe) du particulier

		$this->show('front/service_add', ['post' => $post, 'sectors' => $sectors, 'formErrors' => $formErrors]);
	}

	/**
	 * Affichera la liste des services ou projets par client
	 */
	public function list_services()
	{	

		// si le client n'est pas connecté je le redirige 
		/*if (!empty($this->getUser())) {
			
			$this->redirectToRoute('front_customer_login');
		}*/

		// On récupère les infos du client connecté
		$customer = $this->getUser();
		// On instancie le model pour communiquer avec la BDD
		$projectModel = new ProjectModel();
		$projectModel->setTable('project');

		//On récupère la liste des projets correspondant au client connecté
		$sql = 'SELECT * FROM ' . $projectModel->getTable() . ' WHERE id_customer = :idCustomer';
		$connectionModel = new ConnectionModel();
		$bdd = $connectionModel->getDbh();
		$projects = $bdd->prepare($sql);
		$projects->bindValue(':idCustomer', $customer['id']);
		$projects->execute();

		return $projects->fetchAll();
			
		$this->show('front/service/list_services', ['projects' => $projects]);
	}

}