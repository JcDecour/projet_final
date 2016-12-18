<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\ProjectModel;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function index()
	{

        //Recherche des 5 derniers projets soumis par les particuliers
        $projectModel = new ProjectModel();
        $topProjects = $projectModel->findAll('created_at', 'DESC', null, 5);
       
		$this->show('front/index', ['topProjects' => $topProjects]);
	}

}