<?php

namespace Model;



class DevisModel extends \W\Model\UsersModel
{	
	public function showDevis($devId){
		return $this->find($devId);
	}
}
