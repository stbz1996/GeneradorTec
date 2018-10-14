<?php

class Activity
{
	private $id;
	private $description;
	private $workPorcent;

	function __construct()
	{
		
	}


	/**********************************
	Setters 
	**********************************/
	public function setId($pid)
	{
		$this->id = $pid;
	}

	public function setDescription($pDescription)
	{
		$this->description = $pDescription;
	}

	public function setWorkPorcent($pWorkPorcent)
	{
		$this->workPorcent = $pWorkPorcent;
	}

	/**********************************
	Getters 
	**********************************/
	public function getId()
	{
		return $this->id;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getWorkPorcent()
	{
		return $this->workPorcent;
	}
}

?>