<?php 
namespace Model;

class ProjectSubsectorModel extends \W\Model\Model
{
	/**
	 * Récupère toutes les lignes de la table à partir d'un IdProject
	 * @param  integer Id
	 * @return mixed Les données sous forme de tableau 
	 */
	public function findProjectSubsectorById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_project = :idProject';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $id);
		$sth->execute();

		return $sth->fetchAll();
	}	
}
