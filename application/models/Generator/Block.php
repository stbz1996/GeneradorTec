<?php

class Block
{
	private $id;
    private $name;
    private $plan;

	function __construct()
	{
	}


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
    
	public function setPlan($pPlan)
	{
		$this->plan = $pPlan;
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
    
	public function getPlan()
	{
		return $this->plan;
	}
}

?>