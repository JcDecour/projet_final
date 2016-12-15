<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\SectorModel;
use \Model\SubSectorModel;
use \Model\ProjectModel;
use \Model\DevisModel;
use \Model\ProjectSubsectorModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\CustomerModel;
use \Respect\Validation\Validator as v; 

class ServicesController extends Controller
{
	/**
	 * Page de modification d'une demande de service ou de projet par un particulier
	 */
	public function edit($idProject)
	{
		$projectModel = new ProjectModel();
		$sectorModel = new SectorModel();
		$subSectorModel = new SubSectorModel();
		$projectSubsectorModel = new ProjectSubsectorModel();
		$projectSubSectorModel = new ProjectSubsectorModel();
		$customerModel = new CustomerModel();
		$authModel = new AuthentificationModel();

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

		    //Ctrl que le service comporte au moins une catégorie / Ss-Catégorie
		   	if(!isset($post['tabSsCateg'])){
		    	$formErrors['tabSsCateg'] = 'Le service doit comporter au minimum une catégorie / sous-catégorie.';
		    }

		    //Si aucune erreur de saisie, enregistrement des données en BDD
		    if(count($formErrors) === 0){

		    	//Insertion du service en BDD 
		    	$data = [
		    		'zip_code'			=> $post['zip_code'],
		    		'title'				=> $post['title'],
		    		'description'		=> $post['description'],
		    		'predicted_date'	=> $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0],
		    		'updated_at'		=> date('Y-m-d H:i:s'),
		    	];
				$project = $projectModel->update($data, $idProject);

				if($project){
					//Suppression de toutes les sous catégories
					$projectSubSectorModel->delete($idProject);

					//Insertion des sous catégories du service en BDD
					foreach ($post['tabSsCateg'] as $key => $value) {
						$dataProjectSsSector = [
							'id_project'	=>	$project['id'],
							'id_subsector'	=>	$value,
							'created_at'	=> date('Y-m-d H:i:s'),
						];
						$projectSubSector = $projectSubSectorModel->insert($dataProjectSsSector);
					}
					$this->redirectToRoute('front_list_services');
				}
				else{
					$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';
				}
			}
		}

		//Recherche du projet à éditer si on est pas en post de formulaire (1er chargement du formulaire à partir de la BDD)
		$contenuSsSector = '';
		if(empty($post)){
			$project = $projectModel->find($idProject);
			if($project){
				$post['zip_code'] = $project['zip_code'];
				$post['title'] = $project['title'];
				$post['description'] = $project['description'];
				$post['predicted_date'] = \DateTime::createFromFormat('Y-m-d', $project['predicted_date'])->format('d/m/Y');
			}

			//Construction de la liste des ss_catégories
			$projectSubsectors = $projectSubsectorModel->findProjectSubsectorById($idProject);
			foreach ($projectSubsectors as $key => $projectSubsector) {
				$subSectorResult = $subSectorModel->find($projectSubsector['id_subsector']);
				$sectorResult = $sectorModel->find($subSectorResult['id_sector']);

				$contenuSsSector .= '<div>'.$sectorResult['title'].' - '.$subSectorResult['title'].'<input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/><a href="#" class="remove_ss_categ_button"> Supprimer</a></div>';	
			}
			$contenuSsSector_build = true;
		}

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectors = $sectorModel->findAll('order_num');

		//Reconstruction des ss_sector dans le cas d'un post
		if(!isset($contenuSsSector_build)){
			if(isset($post['tabSsCateg'])){
				foreach ($post['tabSsCateg'] as $key => $value) {
					$subSectorResult = $subSectorModel->find($value);
					$sectorResult = $sectorModel->find($subSectorResult['id_sector']);

					$contenuSsSector .= '<div>'.$sectorResult['title'].' - '.$subSectorResult['title'].'<input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/><a href="#" class="remove_ss_categ_button"> Supprimer</a></div>';	
				}
			}
		}

		$this->show('front/service_edit', ['post' => $post, 'sectors' => $sectors, 'formErrors' => $formErrors, 'contenuSsSector' => $contenuSsSector]);
	}

	/**
	 * Page d'ajout d'une demande de service ou de projet par un particulier
	 */
	public function add()
	{
		$projectModel = new ProjectModel();
		$customerModel = new CustomerModel();
		$authModel = new AuthentificationModel();

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

		 	//Ctrl que le service comporte au moins une catégorie / Ss-Catégorie
		    if(!isset($post['tabSsCateg'])){
		    		$formErrors['tabSsCateg'] = 'Le service doit comporter au minimum une catégorie / sous-catégorie.';
		    }

		    //Cas du client qui n'est pas connecté
		    $customerToCreate = false;
		    $idCustomer = null;
		    if (empty($this->getUser())) {
		
			    //Verification de la validité de l'email
			    if(empty($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
			    	$formErrors['email'] = 'Le format de l\'email saisi est invalide.';
			    }
			    //Verification de la validité du mot de passe
			    elseif(!v::notEmpty()->length(8, 20)->validate($post['password'])){
			    	$formErrors['password'] = 'Le mot de passe doit comporter entre 8 et 20 caractères.';
			    }
			    else{
			    	//Vérification que cet email existe
			    	if($customerModel->emailExists($post['email'])){
			    		//Vérification validité Mot de passe/ Email
			    		$idCustomer = $customerModel->isValidLoginInfo($post['email'], $post['password']);
			    		if ($idCustomer) {
							$customer = $customerModel->find($idCustomer);
							// Connection l'utilisateur et la session est peuplée
							$authModel->logUserIn($customer);
						}
						else{
							$formErrors['global'] = 'Email ou mot de passe invalide.';	
						}
					}
					else {
						//Le customer doit être créé en BDD
						$customerToCreate = true;
					}
			    }
		    }
		    else{
		    	//Récupération de l'id du "Customer" à partir des infos de session
		    	$user = $this->getUser();
		    	$idCustomer = $user['id'];	
		    }

		    //Si aucune erreur de saisie, enregistrement des données en BDD
		    if(count($formErrors) === 0){

		    	//Cas ou il faut créer au préalable le "Customer" en BDD
		    	if($customerToCreate){
		    		$dataCustomer = [
		    			'email'		=>  $post['email'],
		    			'password'	=>	$authModel->hashPassword($post['password'])
		    		];

			    	//Création du "Customer" en BDD
			    	$customer = $customerModel->insert($dataCustomer);
			    	$idCustomer = $customer['id'];
		    	}

		    	//Insertion du service en BDD 
		    	$data = [
		    		'id_customer'		=> $idCustomer, 
		    		'zip_code'			=> $post['zip_code'],
		    		'title'				=> $post['title'],
		    		'description'		=> $post['description'],
		    		'predicted_date'	=> $tabDate[2].'-'.$tabDate[1].'-'.$tabDate[0],
		    		'created_at'		=> date('Y-m-d H:i:s'),
		    		'updated_at'		=> date('Y-m-d H:i:s'),
		    	];
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
					$this->redirectToRoute('front_list_services');
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
	 * Permet de consulter un service pour les utilisateurs non connectés
	 */
	public function viewAllUsers($id)
	{


		$this->show('front/service_view_allusers');
	}



	/**
	 * Afficher la liste des services pour les utilisateurs non connectés
	 */
	public function listAllUsers()
	{

		//Gestion du formulaire de recherche
		$get = [];
		$zip_code = null;
		$sub_sector = null;

		if(!empty($_GET)){
			$get = array_map('trim', array_map('strip_tags', $_GET));

			//Cas d'un recherche sur le code postal
			if(isset($get['zip_code']) && ctype_digit($get['zip_code'])){
				$zip_code = $get['zip_code'];
			}
			//Cas d'un recherche sur la sous-catégorie
			if(!empty($get['sub-sector']) && ctype_digit($get['sub-sector'])){
				$sub_sector = $get['sub-sector'];
			}
		}

		//Recherche de l'ensemble des projets non cloturés
		$projectModel = new ProjectModel();
		$projects = $projectModel->findAllWithoutClosed($zip_code, $sub_sector);

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Si la sous catégorie de la recherche est renseignée, alors il faut reconstruire le menu déroulant de la sous catégorie
		$optionSubSector = '';
		if(!empty($get['sub-sector'])){
			$optionSubSector = '<option value="" selected>Sous-Catégorie</option>';
			$subSectorModel = new SubSectorModel();
			$subSectors = $subSectorModel->findBySectorId($get['sector']);
			foreach ($subSectors as $key => $subSector) {
				if($get['sub-sector'] == $subSector['id']){
					$selected = 'selected';
				}
				else
				{
					$selected = '';
				}
				$optionSubSector.='<option value="'.$subSector['id'].'" '.$selected.'>'.$subSector['title'].'</option>';
			}
		}

		$this->show('front/service_list_allusers', [
				'projects'			=> $projects, 
				'sectors'			=> $sectors,
				'search'			=> $get,
				'optionSubSector'	=> $optionSubSector,
			]);
	}

	/**
	 * Affichera la liste des services ou projets par client
	 */
	public function list_services()
	{	

		// si le client n'est pas connecté je le redirige 
		if (empty($this->getUser())) {
			
			$this->redirectToRoute('front_customer_login');
		}

		// On récupère les infos du client connecté
		$customer = $this->getUser();
		// On instancie le model pour communiquer avec la BDD
		$projectModel = new ProjectModel();

		//On récupère la liste des projets correspondant au client connecté
		$projects = $projectModel->findServiceById($customer['id']);
			
		$this->show('front/list_services', ['projects' => $projects]);
	}

	/**
	 * Page de delete service
	 */
	public function delete_service($id)
	{	
		if (!is_numeric($id) || empty($id)) {
			$this->showNotFound();
		}
		else {
			$post = array_map('trim', array_map('strip_tags', $_POST));
			if (empty($post['delete'])) {
				$projectModel = new ProjectModel();
				$project = $projectModel->find($id);
				$this->show('front/delete_service', ['project' => $project]);
			}
			elseif(!empty($post['delete'])) {
				$projectModel = new ProjectModel();
				$projectModel->delete($id);
				$this->redirectToRoute('front_list_services');
			}
		}
	}

	/**
	 * Affiche le détail d'un service sélectionné
	 * @param $id L'id du projet ou service
	 */
	public function view_service($id) // L'id passé en paramètre doit être le même passé dans la route [i:id]
	{	
		if (!is_numeric($id) || empty($id)) {
			$this->showNotFound();
		}
		else {

			$datas =[];

			// On récupère les données du projet
			$projectModel = new ProjectModel();
			$project = $projectModel->find($id);

			// On récupère toutes les sous-catégories liées au projet
			$projectSubSectorModel = new ProjectSubSectorModel();
			$projectsSubSector = $projectSubSectorModel->findAllProjectSubsectorById($project['id']);


			// On récupère les devis liés au projet ou service
			$devisModel = new DevisModel();
			foreach ($projectsSubSector as $projectSubSector) {
				
				$datasDevis[] = $devisModel->findAllDevisById($projectSubSector['id']);

			}

			//Permet de gérer l'affichage

			$data = [

				'project' => $project,
				'projectsSubSector' => $projectsSubSector,
				'datasDevis' => $datasDevis,
			];
			$this->show('front/view_service', $data);
		}
	}


}