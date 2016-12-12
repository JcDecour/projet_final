<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\SectorModel;
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

			$post = array_map('trim', array_map('strip_tags', $_POST));

			if(!v::notEmpty()->length(5, 5)->validate($post['zip_code'])){
				$formErrors['zip_code'] = 'Le code postal doit comporter 5 caractères.';
			}

			if(!v::notEmpty()->length(10, 80)->validate($post['title'])){
				$formErrors['title'] = 'L\'objet du service doit comporter au moins 10 caractères.';
			}

			if(!v::notEmpty()->length(20, null)->validate($post['description'])){
				$formErrors['description'] = 'Le descriptif du service doit comporter au moins 20 caractères.';
			}

			//Date à controler
			if(!preg_match("#^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$#", $post['predicted_date']))
		    {
		       $formErrors['predicted_date'] = 'La date prévisionnelle est invalide.';
		    }

		}

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Il faut alimenter le CP de la demande de devis avec par défaut le CP (s'il existe) du particulier

		$this->show('front/service_add', ['post' => $post, 'sectors' => $sectors, 'formErrors' => $formErrors]);
	}

}