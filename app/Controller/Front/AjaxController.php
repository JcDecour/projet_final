<?php

namespace Controller\Front;

use \W\Controller\Controller;
use \Model\SubSectorModel;


class AjaxController extends Controller
{

	/**
	 * Function du controler permettant de rafraichir les sous-catégories à partir
	 * de la sélection d'une catégorie
	 */
	public function refreshSubSector()
	{

		$get = [];
		$option = '<option value="" selected disabled>Sous-Catégorie</option>';
		if(!empty($_GET)){
			$get = array_map('trim', array_map('strip_tags', $_GET));

			if(isset($get['idsector']) && ctype_digit($get['idsector'])){
				$subSectorModel = new SubSectorModel();
				$subSectors = $subSectorModel->findBySectorId($get['idsector']);
				foreach ($subSectors as $key => $subSector) {
					$option.='<option value="'.$subSector['id'].'">'.$subSector['title'].'</option>';

				}
			}
		}
		$this->showJson(['option' => $option]);
	}

}