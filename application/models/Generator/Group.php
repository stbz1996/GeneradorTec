<?php

class Group
{
	private $id;
	private $number;

	function __construct()
	{}


	/**********************************
	Setters 
	**********************************/
	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setNumber($pNumber)
	{
		$this->number = $pNumber;
	}


	/**********************************
	Getters
	**********************************/
	public function getId()
	{
		return $this->id;
	}

	public function getNumber()
	{
		return $this->number;
	}
}

?>