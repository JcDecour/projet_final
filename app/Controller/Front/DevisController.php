<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\ProjectSubsectorModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\ProjectModel;
use \Model\DevisModel;
use \Respect\Validation\Validator as v; 

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
		
		$projectSubsectorModel = new ProjectSubsectorModel(); 
		$devisModel = new DevisModel();

		//Recherche du projet, de la catégorie et sous catégorie rattaché
		$projectSubsector = $projectSubsectorModel->findWithProjectAndSectorAndSubsector($id);

		//récupératon du nombre de devis pour cette sous catégorie de projet
		$nbDevis = $projectSubsector['ndDevisProjectSubSector'];

		//Cas de la soumission du formulaire
		//Soumission du formulaire
		$post = [];
		$formErrors = [];
		if(!empty($_POST)){
			$post= array_map('trim',array_map('strip_tags', $_POST));

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
					$data = [
						'nb_devis'	=> ($nbDevis + 1),
					];
					$projectSubsectorUpdate = $projectSubsectorModel->update($data, $id);
					if($projectSubsectorUpdate){
						$this->redirectToRoute('front_devis_list');
					}
					else{
						$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';	
					}
				}
				else{
					$formErrors['global'] = 'Une erreur d\'enregistrement s\'est produite.';
				}
			}

		}

		//Affichage du template
		$this->show('front/devis_add', ['projectSubsector' => $projectSubsector, 'formErrors' => $formErrors]);	
	}
	


}



