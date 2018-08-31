<?php

class Form{
	/****************************************
	Variables
	****************************************/
	private $idForm;
	private $hashCode;
	private $state;
	private $dueDate;
	private $idProfessor;

	function __construct()
	{
		$this->idForm = 0;
		$this->hashCode = "";
		$this->state = false;
		$this->dueDate = 0;
		$this->idProfessor = 0;
	}

	/* Setters and Getters */

	public function setIdForm($pIdForm)
	{
		$this->idForm = $pIdForm;
	}

	public function setHashCode($pHashCode)
	{
		$this->hashCode = $pHashCode;
	}

	public function changeState(){
		if ($this->state)
		{
			$this->state = false;
		}else{
			$this->state = true;
		}
	}

	public function setDueDate($pDueDate)
	{
		$this->dueDate = $pDueDate;
	}

	public function setIdProfessor($pIdProfessor)
	{
		$this->idProfessor = $pIdProfessor;
	}

	public function getId()
	{
		return $this->idCareer;
	}

	public function getHashCode()
	{
		return $this->hashCode;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getDueDate()
	{
		return $this->dueDate;
	}

	public function getIdProfessor()
	{
		return $this->idProfessor;
	}

	/* Finish the setters and getters */


}

?>