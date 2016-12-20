<?php 
namespace Model;

class ProjectModel extends \W\Model\Model
{
	/**
	 * Récupère tous les lignes de la table en fonction de L'idCustomer
	 * @param integer idCustomer Identifiant
	 * @param  string $closed La colonne en fonction de laquelle trier
	 * @param integer $closedValue la valeur de la colonne 'closed'
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function findServiceById($idCustomer, $closedValue = '')
	{
		if (!is_numeric($idCustomer)){
			return false;
		}

		
		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_customer = :idCustomer ';

		if (!empty($closedValue)){

			//sécurisation des paramètres, pour éviter les injections SQL
			if(!preg_match('#^[0-1]{1,1}$#', $closedValue)){
				die('Error: invalid closedValue param');
			}

			$sql .= ' AND closed = '.$closedValue;
			
		}

		$sql .= ' ORDER BY created_at';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':idCustomer', $idCustomer);
		$sth->execute();

		return $sth->fetchAll();
	}

	/**
	 * Récupère toutes les lignes de la table sans les projet "Terminés" (possibilité de filtrer sur le lieu géographique, le secteur, le sous secteur et le titre du services)
	 * @param  integer Code postal auquel les projets doivent etre rattachés
	 * @param  integer Sous Catégories auquel les projets doivent etre rattachés
	 * @return array Les données sous forme de tableau multidimensionnel
	 */
	public function findAllWithoutClosed($zip_code = null, $sub_sector = null, $sector = null, $title = null)
	{
		$sql = 'SELECT distinct p.* FROM ' . $this->table . ' as p 
                INNER JOIN project_subsector as ps ON p.id = ps.id_project
                INNER JOIN sub_sector as ss ON ss.id = ps.id_subsector
                INNER JOIN sector as s ON s.id = ss.id_sector
                WHERE closed = 0';
       
		if(!empty($zip_code) && !ctype_digit($zip_code)){
			return false;
		}
		if(!empty($sub_sector) && !ctype_digit($sub_sector)){
			return false;
		}
        if(!empty($sector) && !ctype_digit($sector)){
			return false;
		}

		if(!empty($zip_code)){
			$sql .= ' AND zip_code = :zip_code';
		}
		if(!empty($sub_sector)){
			$sql .= ' AND id_subsector = :idSub_sector';
		}
        elseif(!empty($sector)){
            $sql .= ' AND s.id = :idSector';   
        }

        if(!empty($zip_code)){
			$sql .= ' AND zip_code = :zip_code';
		}
        if(!empty($title)){
			$sql .= ' AND (p.title LIKE :title OR p.description LIKE :title)';
		}
		$sql .= ' ORDER BY p.id DESC';
        
		$sth = $this->dbh->prepare($sql);
		if(!empty($zip_code)){
			$sth->bindValue(':zip_code', $zip_code);
		}
		if(!empty($sub_sector)){
			$sth->bindValue(':idSub_sector', $sub_sector);
		}
        elseif(!empty($sector)){
            $sth->bindValue(':idSector', $sector);  
        }
        if(!empty($title)){
			$sth->bindValue(':title', '%'.$title.'%');
		}
		$sth->execute();

		return $sth->fetchAll();
	}


	/**
	 * Récupère toutes les lignes de la table avec lignes de détail des sous catégories et sans les projets terminés (possibilité de filtrer sur le secteur et sous secteur)
	 * @param  integer Code postal auquel les projets doivent etre rattachés
	 * @param  integer Sous Catégories auquel les projets doivent etre rattachés
	 * @return array Les données sous forme de tableau multidimensionnel
	 */
	public function findAllDetailWithoutClosed($zip_code = null, $sub_sector = null, $sector = null, $title = null, $idProvider)
	{
		$sql = 'SELECT p.*, subsector.title as titlesubsector, ps.id as idprojetsubsector, ps.nb_devis as nbdevisprojetsubsector, sector.title as titlesector  FROM ' . $this->table . ' as p 
				INNER JOIN project_subsector as ps ON p.id = ps.id_project
				INNER JOIN sub_sector as subsector ON subsector.id = ps.id_subsector
				INNER JOIN sector as sector ON sector.id = subsector.id_sector
				WHERE closed = 0
                AND ps.id NOT IN (SELECT devis.id_project_subsector FROM devis WHERE devis.id_provider = :idProvider AND devis.id_project_subsector = ps.id)';

		if(!empty($zip_code) && !ctype_digit($zip_code)){
			return false;
		}
		if(!empty($sub_sector) && !ctype_digit($sub_sector)){
			return false;
		}
        if(!empty($sector) && !ctype_digit($sector)){
			return false;
		}
        if(empty($idProvider) || !ctype_digit($idProvider)){
			return false;
		}

		if(!empty($zip_code)){
			$sql .= ' AND zip_code = :zip_code';
		}
		if(!empty($sub_sector)){
			$sql .= ' AND id_subsector = :idSub_sector';
		}
        elseif(!empty($sector)){
            $sql .= ' AND sector.id = :idSector';   
        }

        if(!empty($zip_code)){
			$sql .= ' AND zip_code = :zip_code';
		}
        if(!empty($title)){
			$sql .= ' AND (p.title LIKE :title OR p.description LIKE :title)';
		}
		$sql .= ' ORDER BY p.id DESC, sector.order_num ASC, subsector.title ASC';  
        
		$sth = $this->dbh->prepare($sql);
		if(!empty($zip_code)){
			$sth->bindValue(':zip_code', $zip_code);
		}
		if(!empty($sub_sector)){
			$sth->bindValue(':idSub_sector', $sub_sector);
		}
        elseif(!empty($sector)){
            $sth->bindValue(':idSector', $sector);  
        }
        if(!empty($title)){
			$sth->bindValue(':title', '%'.$title.'%');
		}
        $sth->bindValue(':idProvider', $idProvider);  
		$sth->execute();

		return $sth->fetchAll();
	}

	/**
	 * Récupère le nbre total des ervices proposés sur le site (les cloturés sont exclus)
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function countWithoutClosed()
	{
		$sql = 'SELECT count(*) as nbTotalService FROM ' . $this->table . ' WHERE closed = 0';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}

}
