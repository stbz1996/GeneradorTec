<?php

class PlanDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idPlan;
	private $name;
	private $state;
	private $idCareer;

	function __construct()
	{
		$this->idPlan = 0;
		$this->name = "";
		$this->state = false;
		$this->idCareer = 0;
	}

	/* Setters and Getters */

	public function setIdPlan($pIdPlan)
	{
		$this->idPlan = $pIdPlan;
	}

	public function setName($pName)
	{
		$this->name = $pName;
	}

	public function setState($pState)
	{
		$this->state = $pState;
	}

	public function changeState(){
		if ($this->state)
		{
			$this->state = false;
		}else{
			$this->state = true;
		}
	}

	public function setIdCareer($pIdCareer)
	{
		$this->idCareer = $pIdCareer;
	}

	public function getId()
	{
		return $this->idPlan;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getIdCareer()
	{
		return $this->idCareer;
	}

	/* Finish the setters and getters */
}

?>