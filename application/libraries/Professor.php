<?php

class Professor{
	/****************************************
	Variables
	****************************************/
	private $idProfessor;
	private $name;
	private $lastName;
	private $state;
	private $email;
	private $workLoad;
	private $idCareer;


	function __construct()
	{
		$this->idProfessor = 0;
		$this->name = "";
		$this->lastName = "";
		$this->state = false;
		$this->email = "";
		$this->workLoad = 0;
		$this->idCareer = 0;
	}

	/* Setters and Getters */

	public function setIdProfessor($pIdProfessor)
	{
		$this->idProfessor = $pIdProfessor;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function setLastName($pLastName)
	{
		$this->lastName = $pLastName;
	}

	public function changeState(){
		if ($this->state)
		{
			$this->state = false;
		}else{
			$this->state = true;
		}
	}

	public function setEmail($pEmail)
	{
		$this->email = $pEmail;
	}

	public function setWorkLoad($pWorkLoad)
	{
		$this->workLoad = $pWorkLoad;
	}

	public function getId()
	{
		return $this->idProfessor;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getWorkLoad()
	{
		return $this->workLoad;
	}

	public function getIdCareer()
	{
		return $this->idCareer;
	}

	/* Finish the setters and getters */
}

?>