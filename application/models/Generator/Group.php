<?php

class Group
{
	private $id;
	private $number;

	function __construct($pId, $pNumber)
	{
		$this->id = $pId;
		$this->number = $pNumber;
	}

	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setNumber($pNumber)
	{
		$this->number = $pNumber;
	}

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