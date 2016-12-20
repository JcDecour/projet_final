<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\ProjectSubsectorModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\ProjectModel;
use \Model\DevisModel;
use \Model\SectorModel;
use \Model\SubSectorModel;
use \Respect\Validation\Validator as v; 

class DevisController extends Controller
{
	/**
	 * Liste des devis du professionnel
	*/
    public function listService()
	{

		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte customer je le redirige 
		if (!($user) || !isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
        
        //Instanciation des classes
		$sectorModel = new SectorModel();
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
        
        //#####################################################################
        // Partie Liste des Projets disponibles
        //#####################################################################

		//Recherche de tous les projets en détail non terminés et non extimés par le professionnel
        $provider = $this->getUser();
		$projects = $projectModel->findAllDetailWithoutClosed($zip_code, $sub_sector, $sector, $title, $provider['id']);

        //Recherche de tous les "Sector" triés par numéro d'ordre
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
        
        //#####################################################################
        // Partie Devis réalisé par le provider
        //#####################################################################
        
		//Recherche des devis établis par le professionnel
		$devisModel = new DevisModel();
		$provider = $this->getUser();

		$statut = 'all';
		if(isset($get['statut']) && $get['statut'] === 'all'){
			$statut = 'all';
		}
		elseif(isset($get['statut']) && $get['statut'] === 'accepted'){
			$statut = 'accepted';
		}
		elseif(isset($get['statut']) && $get['statut'] === 'notselected'){
			$statut = 'notselected';
		}
		elseif(isset($get['statut']) && $get['statut'] === 'notstatue'){
			$statut = 'notstatue';
		}

		//Recherche des devis du "Provider"
		$devis = $devisModel->findAllWithDetailsByProviderId($provider['id'], $statut);

		$this->show('front/devis_list', [
            'projects'          => $projects,
            'sectors'           => $sectors,
            'optionSubSector'	=> $optionSubSector,
            'search'			=> $get,
            'listdevis'         => $devis,
        ]);	
	}

	/**
	 * Ajout d'un devis par un professionnel
	 * @param $id integer Correspond a l'id de la table ProjectSubsector
	*/
	public function add($id)
	{
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte customer je le redirige 
		if (!($user) || !isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}


		
		if(!is_numeric($id) || empty($id)){
			$this->showNotFound();
		}
		
		$projectSubsectorModel = new ProjectSubsectorModel(); 
		$devisModel = new DevisModel();
		$projectModel = new ProjectModel();

		//Recherche du projet, de la catégorie et sous catégorie rattaché
		$projectSubsector = $projectSubsectorModel->findWithProjectAndSectorAndSubsector($id);

		//Récupératon du nombre de devis pour cette sous catégorie de projet
		$nbDevisProjectSubsector = $projectSubsector['ndDevisProjectSubSector'];
		//Récupératon du nombre de devis pour cette sous catégorie de projet
		$nbDevisProject = $projectSubsector['nb_devis'];

		//Cas de la soumission du formulaire
		//Soumission du formulaire
		$post = [];
		$formErrors = [];
		if(!empty($_POST)){
			$post= array_map('trim',array_map('strip_tags', $_POST));

			//Designation
			if(!v::notEmpty()->length(8, null)->validate($post['description'])){
				$formErrors['description'] = 'La description doit comporter au minimum 10 caractères.';
			}


			//Designation
			if(!v::notEmpty()->length(8, null)->validate($post['designation'])){
				$formErrors['designation'] = 'La désignation doit comporter au minimum 8 caractères.';
			}

			//Montant HT
			if(!v::intVal()->notEmpty()->validate($post['ht_amount'])){
				$formErrors['ht_amount'] = 'Le montant est incorrect.';
			}

			//Si aucune erreur de saisie, enregistrement des données en BDD
		    if(count($formErrors) === 0){

		    	//Insertion du service en BDD
		    	$provider = $this->getUser();
		    	$data = [
		    		'id_project_subsector'	=> $id,
		    		'id_provider'			=> $provider['id'],
		    		'ht_amount'				=> $post['ht_amount'],
		    		'designation'			=> $post['designation'],
		    		'description'			=> $post['description'],
		    		'tva_amount'			=> $post['tva_amount'],
		    		'created_at'			=> date('Y-m-d H:i:s'),
		    		'updated_at'			=> date('Y-m-d H:i:s'),
		    	];
				$devis = $devisModel->insert($data);
				if($devis){
					//Mise a jour du compteur de devis pour la sous catégorie du projet concerné
					$dataProjectSubsector = [
						'nb_devis'	=> ($nbDevisProjectSubsector + 1),
					];
					$projectSubsectorUpdate = $projectSubsectorModel->update($dataProjectSubsector, $id);
					if($projectSubsectorUpdate){
						//Mise à jour du compteur de devis du projet
						$dataProject = [
							'nb_devis'	=> ($nbDevisProject + 1),
						];
						$projectUpdate = $projectModel->update($dataProject, $projectSubsectorUpdate['id_project']);
						if($projectUpdate){
							$this->redirectToRoute('front_devis_list');
						}
					}
				}

				//Cas d'une erreur d'enregistrement
				$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';
			}

		}

		//Affichage du template
		$this->show('front/devis_add', ['projectSubsector' => $projectSubsector, 'formErrors' => $formErrors, 'post' => $post]);	
	}
	
    /**
	 * Controlleur de consultation d'un devis
	 * @param $id integer Correspond a l'id du devis à consulter
	*/
	public function view($id)
	{	
		$user = $this->getUser();
		
		// si le client n'est pas connecté ou connecté en compte customer je le redirige 
		if (!($user) || !isset($user['siret'])) {
			
			$this->redirectToRoute('front_default_index');
		}
        //Recherche du devis à consulter
        $devisModel = new DevisModel;
        $devis = $devisModel->findWithDetailsById($id);
        
        $this->show('front/devis_view', ['devis' => $devis]);
    }
    
 

}



