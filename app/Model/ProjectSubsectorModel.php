<?php 
namespace Model;

class ProjectSubsectorModel extends \W\Model\Model
{
	/**
	 * Récupère une ligne de la table en fonction d'un identifiant
	 * @param  integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function findWithProjectAndSectorAndSubsector($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$sql = 'SELECT p.*, subsector.title as titlesubsector, sector.title as titlesector, ' .$this->table. '.nb_devis as ndDevisProjectSubSector FROM ' . $this->table . '
				INNER JOIN project as p ON p.id = ' . $this->table . '.id_project
				INNER JOIN sub_sector as subsector ON subsector.id = ' . $this->table . '.id_subsector
				INNER JOIN sector as sector ON sector.id = subsector.id_sector
				WHERE ' . $this->table . '.' . $this->primaryKey .'  = :id LIMIT 1';

		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetch();
	}

	/**
	 * Récupère toutes les lignes de la table à partir d'un Id de project
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
	 * Récupère des lignes des deux tables de jointure project_subsector et sub_sector à partir d'un idProject
	 * @param $id integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif triées sur le prix hors taxe	  
	*/
	public function findAllProjectSubsectorById($id)
	{
		if (!is_numeric($id)){
			return false;
		}

		$subSectorModel = new SubSectorModel();

		$sql = 'SELECT ps.id, s.title FROM ' . $this->table .' as ps INNER JOIN '.$subSectorModel->getTable().' as s ON s.id = ps.id_subsector WHERE ps.id_project = :id ';

		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
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
