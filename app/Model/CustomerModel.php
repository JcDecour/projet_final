<?php 
namespace Model;

use \W\Model\ConnectionModel;

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
}
