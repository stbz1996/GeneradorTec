<?php

class AdministratorDTO{
	/****************************************
	Variables
	****************************************/
	private $idAdministrator;
	private $user;
	private $password;

	function __construct()
	{
		$this->idAdministrator = 0;
		$this->user = "";
		$this->password = "";
	}

	/* Setters and Getters */

	public function setIdAdministrator($pIdAdministrator)
	{
		$this->idAdministrator = $pIdAdministrator;
	}

	public function setUser($pUser)
	{
		$this->user = $pUser;
	}

	public function setPassword($pPassword)
	{
		$this->password = $pPassword;
	}

	public function getId()
	{
		return $this->idAdministrator;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPassword()
	{
		return $this->password;
	}

	/* Finish the setters and getters */
}

?>