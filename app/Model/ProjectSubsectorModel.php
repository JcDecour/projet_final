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

	/**
	 * Supprime toutes les lignes en fonction de l'identifiant du projet
	 * @param mixed $idProject L'identifiant projet des lignes à effacer
	 * @return mixed La valeur de retour de la méthode execute()
	 */
	public function delete($idProject)
	{
		if (!is_numeric($idProject)){
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table . ' WHERE id_project = :idProject';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idProject', $idProject);
		return $sth->execute();
	}
}
