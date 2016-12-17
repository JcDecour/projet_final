<?php

namespace Model;

use \Model\ProviderModel;
use \Model\ProjectSubsectorModel;

class DevisModel extends \W\Model\Model
{	

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
                    INNER JOIN project as project ON project.id = ps.id_project
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
    
    /**
	 * Récupère la ligne de la table à partir d'un id de "devis"
	 * @param $id integer Identifiant du devis
	 * @return mixed Les données sous forme de tableau associatif avec les donnés de "Projet", "ProjectSubSector", "Customer", "SubSector", "Sector"
	 */
	public function findWithDetailsById($idDevis)
	{
		if (!is_numeric($idDevis)){
			return false;
		}

		$sql = 'SELECT devis.*, 
                    project.zip_code as projectZipCode,
                    project.title as projectTitle,
                    project.description as projectDescription, 
                    project.predicted_date as projectPredicted,
                    project.closed as projectClosed,
                    customer.civilite,
                    customer.firstname,
                    customer.lastname,
                    customer.email,
                    customer.street,
                    customer.zipcode,
                    customer.city,
                    customer.fixed_phone,
                    customer.mobile_phone,
                    sector.title as titleSector, 
                    subsector.title as titleSubsector 
                    FROM ' . $this->table . ' as devis 
                    INNER JOIN project_subsector as ps ON ps.id = devis.id_project_subsector 
                    INNER JOIN sub_sector as subsector ON subsector.id = ps.id_subsector 
                    INNER JOIN sector as sector ON sector.id = subsector.id_sector 
                    INNER JOIN project as project ON project.id = ps.id_project
                    INNER JOIN customer as customer ON customer.id = project.id_customer
                    WHERE devis.id = :idDevis 
                    ORDER BY created_at DESC';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idDevis', $idDevis);
		$sth->execute();

		return $sth->fetch();
	}	


}
