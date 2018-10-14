<?php

class Plan
{
	private $id;
	private $name;

	function __construct()
	{}


	/**********************************
	Setters 
	**********************************/
	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}


	/**********************************
	Getters
	**********************************/
	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}
}

?>