<?php

namespace Model;

use \Model\ProviderModel;

class DevisModel extends \W\Model\Model
{	
	/**
	 * Récupère toutes les lignes de la table à partir d'un IdProject
	 * @param $id integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe
	 */
	public function findDevisById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_project = :idProject ORDER BY ht_amount';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $id);
		$sth->execute();

		return $sth->fetchAll();
	}	

	/**
	 * Récupère des lignes des deux tables de jointure à partir d'un idProject
	 *  @param $id integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe	  
	*/
	public function findAllDevisById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$providerModel = new ProviderModel();

		$sql = 'SELECT d.id, d.created_at, d.ht_amount, d.tva_amount, p.company_name FROM ' . $this->table .' as d INNER JOIN '.$providerModel->getTable().' as p ON p.id = d.id_provider WHERE d.id_project = :idProject ORDER BY d.ht_amount ';

		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $id);
		$sth->execute();

		return $sth->fetchAll();
	}	
}
