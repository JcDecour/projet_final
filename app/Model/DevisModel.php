<?php

namespace Model;



class UsersModel extends \W\Model\UsersModel
{	
	public function showDevis($devId){
		return $this->find($devId);
	}
