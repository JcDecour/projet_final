<?php 
namespace Model;

class ProjectSubsectorModel extends \W\Model\Model
{
	/**
	 * Récupère toutes les lignes de la table à partir d'un IdProject
	 * @param  integer IdProject
	 * @return mixed Les données sous forme de tableau 
	 */
	public function findByProjectId($idProject)
	{
		if (!is_numeric($idProject)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_project = :idProject';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $idProject);
		$sth->execute();

		return $sth->fetchAll();
	}	
}
