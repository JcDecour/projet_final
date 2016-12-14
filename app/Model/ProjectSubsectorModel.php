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
	 * Récupère des lignes des deux tables de jointure project_subsector et sub_sector à partir d'un idProject
	 *  @param $id integer Identifiant
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
}
