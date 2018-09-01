<?php

class GroupDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idGroup;
	private $number;

	function __construct()
	{
		$this->idGroup = 0;
		$this->number = 0;
	}

	/* Setters and Getters */

	public function setIdGroup($pIdGroup)
	{
		$this->idGroup = $pIdGroup;
	}

	public function setNumber($pNumber)
	{
		$this->number = $pNumber;
	}

	public function getId()
	{
		return $this->idGroup;
	}

	public function getNumber()
	{
		return $this->number;
	}

	/* Finish the setters and getters */


}

?>