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
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}

		$projectModel = new ProjectModel();
		$sectorModel = new SectorModel();
		$subSectorModel = new SubSectorModel();
		$projectSubsectorModel = new ProjectSubsectorModel();
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
                    
					$projectSubsectorModel->delete($idProject);

					//Insertion des sous catégories du service en BDD
					foreach ($post['tabSsCateg'] as $key => $value) {
						$dataProjectSsSector = [
							'id_project'	=>	$project['id'],
							'id_subsector'	=>	$value,
							'created_at'	=> date('Y-m-d H:i:s'),
						];
						$projectSubSector = $projectSubsectorModel->insert($dataProjectSsSector);
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

				$contenuSsSector .= '<div><span class="tag label label-categories">'.$sectorResult['title'].' - '.$subSectorResult['title'].'&nbsp;<a href="#" class="remove_ss_categ_button">x</a></span><input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/></div>';	
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

					$contenuSsSector .= '<div><span class="tag label label-categories">'.$sectorResult['title'].' - '.$subSectorResult['title'].'&nbsp;<a href="#" class="remove_ss_categ_button">x</a></span><input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/></div>';		
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


				$contenuSsSector .= '<div><span class="tag label label-categories">'.$sectorResult['title'].' - '.$subSectorResult['title'].'&nbsp;<a href="#" class="remove_ss_categ_button">x</a></span><input type="hidden" value="'.$subSectorResult['id'].'" name="tabSsCateg[]"/></div>';	
			}
		}

		$this->show('front/service_add', ['post' => $post, 'sectors' => $sectors, 'formErrors' => $formErrors, 'contenuSsSector' => $contenuSsSector]);
	}

	/**
	 * Permet de consulter un service pour les utilisateurs non connectés
	 */
	public function viewAllUsers($id)
	{
		$projectModel = new ProjectModel();
		$project = $projectModel->find($id);

		$projectSubsectorModel = new ProjectSubsectorModel();
		$sectorModel = new SectorModel();
		$subSectorModel = new SubSectorModel();
		$projectSubsectors = $projectSubsectorModel->findProjectSubsectorById($id);

		$contenuSsSector = '';
		foreach ($projectSubsectors as $key => $value) {
			$subSector = $subSectorModel->find($value['id_subsector']);
			if($subSector){
				$sector = $sectorModel->find($subSector['id_sector']);
				if($sector){
					$contenuSsSector.= '<span class="tag label label-categories">'.$sector['title'].' - '.$subSector['title'].'</span><br>';
				}
			}
		}
        
		$this->show('front/service_view_allusers', ['project' => $project, 'contenuSsSector' => $contenuSsSector]);
	}



	/**
	 * Afficher la liste des services pour les utilisateurs non connectés
	 */
	public function listAllUsers()
	{
		//Instanciation de la classe "ProjectModel"
		$projectModel = new ProjectModel();

		//Gestion du formulaire de recherche
		$get = [];
		$zip_code = null;
		$sub_sector = null;
        $sector = null;
        $title = null;

		if(!empty($_GET)){
			$get = array_map('trim', array_map('strip_tags', $_GET));

			//Cas d'un recherche sur le code postal
			if(isset($get['zip_code']) && ctype_digit($get['zip_code'])){
				$zip_code = $get['zip_code'];
			}
			//Cas d'une recherche sur la sous-catégorie
			if(!empty($get['sub-sector']) && ctype_digit($get['sub-sector'])){
				$sub_sector = $get['sub-sector'];
			}
            //Cas d'un recherche sur la catégorie
			if(!empty($get['sector']) && ctype_digit($get['sector'])){
				$sector = $get['sector'];
			}
			//Cas d'un recherche sur la catégorie
			if(!empty($get['title'])){
				$title = $get['title'];
			}
		}

		//Recherche du nombre de services à pourvoir (Les clôturés sont donc exclus)
		$projectsTotal = $projectModel->countWithoutClosed();

		//Recherche de l'ensemble des projets non cloturés en tenant compte du filtre de recherche
		$projects = $projectModel->findAllWithoutClosed($zip_code, $sub_sector, $sector, $title);

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Si la sous catégorie de la recherche est renseignée, alors il faut reconstruire le menu déroulant de la sous catégorie
		$optionSubSector = '';
		if(!empty($get['sector'])){
			$optionSubSector = '<option value="" selected>Sous-Catégorie</option>';
			$subSectorModel = new SubSectorModel();
			$subSectors = $subSectorModel->findBySectorId($get['sector']);
			foreach ($subSectors as $key => $subSector) {
				if((isset($get['sub-sector'])) && ($get['sub-sector'] == $subSector['id'])){
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
				'projectsTotal'	=> $projectsTotal,
			]);
	}

	/**
	 * Affichera la liste des services ou projets par client
	 */
	public function list_services()
	{	

		$get = [];
		$msg = '';

		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}


		// On récupère les infos du client connecté
		$customer = $this->getUser();
	
		// On instancie le model pour communiquer avec la BDD
		$projectModel = new ProjectModel();

		//On récupère la liste des projets correspondant au client connecté
		// S'il y a un ordre de tri
		if(!empty($_GET)){
			$get = array_map('trim', array_map('strip_tags', $_GET));

			//Recherche de tous les devis
			if(isset($get['statut']) && $get['statut'] === 'all'){
				$projects = $projectModel->findServiceById($customer['id']);
				if (!$projects) {
					
					$msg = 'Vous n\'avez aucun service encours';
				}
			}
			//Recherche de tous les devis qui ont un statut "Ouvert"
			if(isset($get['statut']) && $get['statut'] === 'opened'){
				$projects = $projectModel->findServiceById($customer['id'], 0);
				if (!$projects) {
					
					$msg = 'Vous n\'avez aucun service ouvert';
				}
			}
            //Recherche de tous les devis qui ont un statut "Cloturé"
			if(isset($get['statut']) && $get['statut'] === 'closed'){
				$projects = $projectModel->findServiceById($customer['id'], 1);
				if (!$projects) {
					
					$msg = 'Vous n\'avez aucun service cloturé';
				}
			}

			
		}
		else {

			$projects = $projectModel->findServiceById($customer['id']);
			if (!$projects) {
					
					$msg = 'Vous n\'avez aucun service encours';
				}
		}

		$this->show('front/list_services', ['projects' => $projects, 'msg' => $msg, 'get' => $get]);
	}

	/**
	 * Page de delete service
	 */
	public function delete_service($id)
	{	
		$post = [];
		$msg = '';

		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}

		if (!is_numeric($id) || empty($id)) {
			$this->showNotFound();
		}

		if(!empty($_POST)){

			$post = array_map('trim', array_map('strip_tags', $_POST));

			$projectModel = new ProjectModel();
			$project = $projectModel->find($id);

			if ($project) {
				
				$projectModel->delete($id);

				$msg = 'success';
				
			}
			else {

				$msg = 'error';
		
			}
		
		}
		$this->show('front/delete_service', [ 'msg' => $msg ]);

	}

	/**
	 * Affiche le détail d'un service sélectionné
	 * @param $id L'id du projet ou service
	 */
	public function view_service($id) // L'id passé en paramètre doit être le même passé dans la route [i:id]
	{	
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
		// On instancie les classes
		$projectModel = new ProjectModel();
		$customerModel = new CustomerModel();
		$projectSubSectorModel = new ProjectSubSectorModel();
		$devisModel = new DevisModel();
		$sectorModel = new SectorModel();
		

		if (!is_numeric($id) || empty($id)) {
			$this->showNotFound();
		}
		else {

			$datas =[];
			$post =[];

			if (!empty($_POST)) {
				
				$post = array_map('trim', array_map('strip_tags', $_POST));

				foreach ($post as $key => $value) {
					
					$devisModel->update(['accepted' => 1], $value);
					$devis = $devisModel->find($value);
					$projectSS = $projectSubSectorModel->find($devis['id_project_subsector']);
					$projectModel->update(['closed' => 1], $projectSS['id_project']);

					$this->redirectToRoute('front_list_services');
				}

			}

			// On récupère les données du projet
			$project = $projectModel->find($id);
		
			// On récupère les données du client 
			$customer = $customerModel->find($project['id_customer']);

			/** On vérifie si son profil est complet pour pouvoir consulter les offres de devis */

			if (empty($customer['lastname'])) {
				
				$errorConsult = true;

				$projects = $projectModel->findServiceById($customer['id']);

				$data = [

				'projects' => $projects,
				'errorConsult' => $errorConsult,

				];

				$this->show('front/list_services', $data);
				
			}

			// On récupère toutes les catégories et les sous-catégories liées au projet
			$sectors = $sectorModel->findAllSectorsByProjectId($project['id']);

			// On récupère toutes les catégories liés au projet 




			// On récupère les devis liés au projet ou service
			$datasDevis = $devisModel->findAllDevisByProjectId($project['id']);
			//Envoi des données à la page

			$data = [

				'project' => $project,
				'sectors' => $sectors,
				'datasDevis' => $datasDevis,

			];
			$this->show('front/view_service', $data);
		}
	}

	 /**
	 * Controleur de consultation d'un service par le particulier qui a été cloturé
	 * @param $id integer Correspond a l'id du projet à consulter
	*/
	public function viewClosed($id)
	{
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte pro je le redirige 
		if (!($user) || isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
		
        $projectModel = new ProjectModel();
        $projectSubSectorModel = new ProjectSubSectorModel();
        
        $project = $projectModel->find($id);
        $projectSubSectors = $projectSubSectorModel->findAllWithDetailsByIdProject($id);

        $this->show('front/view_service_closed', ['project' => $project, 'projectSubSectors' => $projectSubSectors]);
    }
    

}