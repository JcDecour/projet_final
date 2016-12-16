<?php

namespace Model;

use \Model\ProviderModel;
use \Model\ProjectSubsectorModel;

class DevisModel extends \W\Model\Model
{	

	/**
	 * Récupère des lignes de la jointure des deux tables provider et devis à partir d'un id
	 *  @param $id integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe	  
	*/
	public function findAllDevisById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$providerModel = new ProviderModel();

		$sql = 'SELECT d.*, p.*, d.ht_amount*(1 + d.tva_amount/100) as ttc_amount FROM ' . $this->table .' as d INNER JOIN '.$providerModel->getTable().' as p ON p.id = d.id_provider WHERE d.id_project_subsector = :id ORDER BY d.ht_amount';

		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetchAll();
	}

}
