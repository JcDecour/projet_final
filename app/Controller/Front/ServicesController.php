<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\SectorModel;

class ServicesController extends Controller
{

	/**
	 * Page d'ajout de demande d'un service ou projet par un particulier
	 */
	public function add()
	{

		//Recherche de tous les "Sector" triés par numéro d'ordre
		$sectorModel = new SectorModel();
		$sectors = $sectorModel->findAll('order_num');

		//Il faut alimenter le CP de la demande de devis avec par défaut le CP (s'il existe) du particulier

		$this->show('front/service_add', ['sectors' => $sectors]);
	}

}