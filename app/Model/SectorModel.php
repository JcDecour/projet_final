<?php 
namespace Model;

class SectorModel extends \W\Model\Model
{
	/**
	 * Récupère toutes les lignes de la table à partir d'un id de "Project"
	 * @param $idProject integer Identifiant du provider
	 * @return mixed Les données sous forme de tableau associatif triées montant TTC
	 */
	public function findAllSectorsByProjectId($idProject)
	{
		if (!is_numeric($idProject)){
			return false;
		}

		$sql = 'SELECT                    
                    s.title as sectorTitle,
                    ss.title as subSectorTitle,
                    ps.id as projectSubSectorId                
                    FROM ' . $this->table . ' as s 
                    INNER JOIN sub_sector as ss ON s.id = ss.id_sector 
                    INNER JOIN project_subsector as ps ON ps.id_subsector = ss.id                    
                    WHERE ps.id_project = :idProject 
                    ORDER BY s.order_num DESC';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $idProject);
		$sth->execute();

		return $sth->fetchAll();

	}	
}
