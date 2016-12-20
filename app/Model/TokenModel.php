<?php 
namespace Model;
use \Respect\Validation\Validator as v;

class TokenModel extends \W\Model\Model
{
	/**
	 * Récupère une ligne de la table en fonction d'un token
	 * @param  string I$token
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function findByToken($token)
	{
		if (!is_string($token)){
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE token  = :token LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':token', $token);
		$sth->execute();

		return $sth->fetch();
	}

}
