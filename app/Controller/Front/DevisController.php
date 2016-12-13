<?php

namespace Controller\Front;


use \W\Controller\Controller;
use \Model\CustomerModel;
use \W\Security\AuthentificationModel;
use \W\Security\AuthorizationModel;
use \Model\DevisModel;

class DevisController extends Controller
{
	public function devisProf($id)
	{
		if(!is_numeric($id) || empty($id)){
			$this->show()

		}
		$DevisController =
		$this->show('front/devis_prof');
	}
}



