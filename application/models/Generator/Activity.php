<?php

class Activity
{
	private $id;
	private $description;
	private $workPorcent;

	function __construct($pId, $pDescription, $pWorkPorcent)
	{
		$this->id = $pId;
		$this->description = $pDescription;
		$this->workPorcent = $pWorkPorcent;
	}

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