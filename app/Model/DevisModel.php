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
	 * Récupère toutes les lignes de la table à partir d'un id de "Project"
	 * @param $idProject integer Identifiant du provider
	 * @return mixed Les données sous forme de tableau associatif triées montant TTC
	 */
	public function findAllDevisByProjectId($idProject)
	{
		if (!is_numeric($idProject)){
			return false;
		}

		$sql = 'SELECT d.*, 
                    d.ht_amount*(1 + d.tva_amount/100) as ttc_amount,
                    d.id as devisId,
                    d.created_at as devisDateCreat, 
                    p.company_name as companyName, 
                    p.siret as companySiret, 
                    p.email as companyEmail,
                    ps.id as projectSubsectorId 
                    FROM ' . $this->table . ' as d 
                    INNER JOIN provider as p ON p.id = d.id_provider 
                    INNER JOIN project_subsector as ps ON ps.id = d.id_project_subsector                    
                    WHERE ps.id_project = :idProject 
                    ORDER BY ttc_amount DESC';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $idProject);
		$sth->execute();

		return $sth->fetchAll();
	}	


}
