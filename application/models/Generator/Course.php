<?php

class Course
{
	private $id;
	private $name;
    private $code;
    private $totalLessons;
    private $block;

	function __construct()
	{}

	public function setId($pId)
	{
		$this->id = $pId;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function setCode($pCode)
	{
		$this->code = $pCode;
	}

	public function setTotalLessons($pTotalLessons)
	{
		$this->totalLessons = $pTotalLessons;
	}

	public function setBlock($pBlock)
	{
		$this->block = $pBlock;
	}

	public function getId()
	{
		return $this->id;
    }
    
	public function getName()
	{
		return $this->name;
    }
    
	public function getCode()
	{
		return $this->code;
    }
    
	public function getTotalLessons()
	{
		return $this->totalLessons;
    }
    
	public function getBlock()
	{
		return $this->block;
	}
}

?>