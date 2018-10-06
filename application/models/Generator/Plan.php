<?php

class Plan
{
	private $id;
	private $name;

	function __construct($pId, $pName)
	{
		$this->id = $pId;
		$this->name = $pName;
	}

	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

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