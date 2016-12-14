<?php 
namespace Model;

class ProjectModel extends \W\Model\Model
{
	/**
	 * Récupère tous les services ou projets en fonction d'un identifiant
	 * @param  integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function findServiceById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_customer = :idCustomer ORDER BY created_at';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idCustomer', $id);
		$sth->execute();

		return $sth->fetchAll();
	}


	/**
	 * Récupère toutes les lignes de la table
	 
	 * @return array Les données sous forme de tableau multidimensionnel
	 */
	public function findAllWithoutClosed()
	{
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE closed = 0 ORDER BY created_at DESC';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

}
