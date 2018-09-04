<?php

class BlockDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idBlock;
	private $name;
	private $state;
	private $idPlan;

	function __construct()
	{
		$this->idBlock = 0;
		$this->name = "";
		$this->state = false;
		$this->idPlan = 0;
	}

	/* Setters and Getters */

	public function setIdBlock($pIdBlock)
	{
		$this->idBlock = $pIdBlock;
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

	public function setIdPlan($pIdPlan)
	{
		$this->idPlan = $pIdPlan;
	}

	public function getId()
	{
		return $this->idBlock;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getState()
	{
		return $this->state;
	}

	public function getIdPlan()
	{
		return $this->idPlan;
	}

	/* Finish the setters and getters */
}

?>