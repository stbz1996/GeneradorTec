<?php

class Plan
{
	private $id;
    private $name;
    private $plan

	function __construct($pId, $pName, $pPlan)
	{
		$this->id = $pId;
        $this->name = $pName;
        $this->plan = $pPlan;
	}

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