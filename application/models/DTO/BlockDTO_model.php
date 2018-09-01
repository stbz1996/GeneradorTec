<?php

class BlockDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idBlock;
	private $description;
	private $state;
	private $idPlan;

	function __construct()
	{
		$this->idBlock = 0;
		$this->description = "";
		$this->state = false;
		$this->idPlan = 0;
	}

	/* Setters and Getters */

	public function setIdBlock($pIdBlock)
	{
		$this->idBlock = $pIdBlock;
	}

	public function setDescription($pDescription)
	{
		$this->description = $pDescription;
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

	public function getDescription()
	{
		return $this->description;
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