<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\ProjectModel;
use \Model\DevisModel;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function index()
	{

        //Recherche des 5 derniers projets soumis par les particuliers
        $projectModel = new ProjectModel();
        $topProjects = $projectModel->findAll('created_at', 'DESC', 4);
       
        //Recherche des 5 meilleurs professionnels
        $devisModel = new DevisModel();
        $devis = $devisModel->findBestProfessionnels(4);

        //Affichage du template
		$this->show('front/index', ['topProjects' => $topProjects, 'devis' => $devis]);
	}

	/**
	 * Page CGU
	 */
	public function cgu()
	{

        //Affichage du template
		$this->show('front/cgu');
	}


}