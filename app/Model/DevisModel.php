<?php

namespace Model;

use \Model\ProviderModel;
use \Model\ProjectSubsectorModel;

class DevisModel extends \W\Model\Model
{	

	/**
	 * Récupère toutes les lignes de la table à partir d'un id de Project
	 * @param $id integer Identifiant du projet
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe
	 */
	public function findDevisById($idProject)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_project = :idProject ORDER BY ht_amount';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $idProject);
		$sth->execute();

		return $sth->fetchAll();
	}

	/**
	 * Récupère toutes les lignes de la table à partir d'un id de "Provider"
	 * @param $id integer Identifiant du provider
	 * @return mixed Les données sous forme de tableau associatif triées sur la date de création descendante
	 */
	public function findAllWithDetailsByProviderId($idProvider)
	{
		if (!is_numeric($idProvider)){
			return false;
		}

		$sql = 'SELECT devis.*, 
                    project.zip_code as projectZipCode, 
                    project.closed as projectClosed, 
                    project.title as projectTitle, 
                    project.predicted_date as projectPredicted, 
                    sector.title as titleSector, 
                    subsector.title as titleSubsector 
                    FROM ' . $this->table . ' as devis 
                    INNER JOIN project_subsector as ps ON ps.id = devis.id_project_subsector 
                    INNER JOIN sub_sector as subsector ON subsector.id = ps.id_subsector 
                    INNER JOIN sector as sector ON sector.id = subsector.id_sector 
                    INNER JOIN project as project ON project.id = subsector.id_sector 
                    WHERE id_provider = :idProvider 
                    ORDER BY created_at DESC';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProvider', $idProvider);
		$sth->execute();

		return $sth->fetchAll();
	}	

	/**
	 * Récupère des lignes de la jointure des deux tables provider et devis à partir d'un id de 'Sous catégorie de projet"
	 *  @param $id integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe	  
	*/
	public function findAllDevisById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$providerModel = new ProviderModel();

		$sql = 'SELECT d.*, p.*, d.ht_amount*(1 + d.tva_amount/100) as ttc_amount FROM ' . $this->table .' as d INNER JOIN '.$providerModel->getTable().' as p ON p.id = d.id_provider WHERE d.id_project_subsector = :idSubsectorProject ORDER BY d.ht_amount';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idSubsectorProject', $id);
		$sth->execute();

		return $sth->fetchAll();
	}

}
