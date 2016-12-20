<?php 
namespace Model;

use \W\Model\ConnectionModel;
use \W\Model\UsersModel;
use \W\Security\AuthentificationModel;
use \Respect\Validation\Validator as v;

class CustomerModel extends \W\Model\Model
{
	/**
	 * Récupère un client en fonction de son email 
	 * @param string $email L'email d'un client
	 * @return mixed Le client, ou false si non trouvé
	 */
	public function getUserByEmail($email)
	{

		$app = getApp();

		$sql = 'SELECT * FROM ' . $this->table . 
			   ' WHERE '. $app->getConfig('security_email_property') . ' = :email LIMIT 1';

		$dbh = ConnectionModel::getDbh();
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':email', $email);
		
		if($sth->execute()){
			$foundCustomer = $sth->fetch();
			if($foundCustomer){
				return $foundCustomer;
			}
		}

		return false;
	}

	/**
	 * Vérifie qu'une combinaison d'email et mot de passe (en clair) sont présents en bdd et valides
	 * @param  string $email L'email à tester
	 * @param  string $plainPassword Le mot de passe en clair à tester
	 * @return int  0 si invalide, l'identifiant de l'utilisateur si valide
	 */
	public function isValidLoginInfo($email, $plainPassword)
	{

		$app = getApp();
		$email = strip_tags(trim($email));
		$foundCustomer = $this->getUserByEmail($email);
		if(!$foundCustomer){
			return 0;
		}

		if(password_verify($plainPassword, $foundCustomer[$app->getConfig('security_password_property')])){
			return (int) $foundCustomer[$app->getConfig('security_id_property')];
		}

		return 0;
	}

	/**
	* Teste si un email est présent en base de données
	* @param string $email L'email à tester
	* @return boolean true si présent en base de données, false sinon
	*/
	public function emailExists($email)
	{

	   $app = getApp();

	   $sql = 'SELECT ' . $app->getConfig('security_email_property') . ' FROM ' . $this->table .
	          ' WHERE ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

	   $dbh = ConnectionModel::getDbh();
	   $sth = $dbh->prepare($sql);
	   $sth->bindValue(':email', $email);
	   if($sth->execute()){
	       $foundUser = $sth->fetch();
	       if($foundUser){
	           return true;
	       }
	   }

	   return false;
	}

	/**
	 * Modifie une ligne en fonction d'un email
	 * @param array $data Un tableau associatif de valeurs à insérer
	 * @param mixed $email L'email de la ligne à modifier
	 * @param boolean $stripTags Active le strip_tags automatique sur toutes les valeurs
	 * @return mixed false si erreur, les données mises à jour sinon
	 */
	public function updateByEmail(array $data, $email, $stripTags = true)
	{	
		if(!v::notEmpty()->email()->validate($email)){		
			return false;
		}
		
		$sql = 'UPDATE ' . $this->table . ' SET ';
		foreach($data as $key => $value){
			$sql .= "`$key` = :$key, ";
		}
		// Supprime les caractères superflus en fin de requète
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE email = :email';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value){
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, $value);
		}
		$sth->bindValue(':email', $email);

		if(!$sth->execute()){
			return false;
		}
		return true;
	}


}
