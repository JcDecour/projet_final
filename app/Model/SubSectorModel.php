<?php 
namespace Model;

class SubSectorModel extends \W\Model\Model
{
	/**
	 * Récupère toutes les lignes de la table à partir d'un IdSector
	 * @param  integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le numéro d'ordre de la sous-catégorie
	 */
	public function findBySectorId($idSector)
	{
		if (!is_numeric($idSector)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_sector = :idSector ORDER BY order_num';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idSector', $idSector);
		$sth->execute();

		return $sth->fetchAll();
	}	
}
