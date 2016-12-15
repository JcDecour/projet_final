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
	 * @param  integer Code postal auquel les projets doivent etre rattachés
	 * @param  integer Sous Catégories auquel les projets doivent etre rattachés
	 * @return array Les données sous forme de tableau multidimensionnel
	 */
	public function findAllWithoutClosed($zip_code = null, $sub_sector = null)
	{
		$sql = 'SELECT distinct p.* FROM ' . $this->table . ' as p INNER JOIN project_subsector as ps ON p.id = ps.id_project WHERE closed = 0 ';

		if(!empty($zip_code) && !ctype_digit($zip_code)){
			return false;
		}
		if(!empty($sub_sector) && !ctype_digit($sub_sector)){
			return false;
		}

		if(!empty($zip_code)){
			$sql .= ' AND zip_code = :zip_code';
		}
		if(!empty($sub_sector)){
			$sql .= ' AND id_subsector = :sub_sector';
		}
		$sql .= ' ORDER BY created_at DESC';

		$sth = $this->dbh->prepare($sql);
		if(!empty($zip_code)){
			$sth->bindValue(':zip_code', $zip_code);
		}
		if(!empty($sub_sector)){
			$sth->bindValue(':sub_sector', $sub_sector);
		}
		$sth->execute();

		return $sth->fetchAll();
	}
}
