<?php

class GeneratorDTO_model{
	/****************************************
	Variables
	****************************************/
	private $idGenerator;
	private $sequence;

	function __construct()
	{
		$this->idGenerator = 0;
		$this->sequence = 0;
	}

	/* Setters and Getters */

	public function setIdGenerator($pIdGenerator)
	{
		$this->idGenerator = $pIdGenerator;
	}

	public function setSequence($pSequence)
	{
		$this->sequence = $pSequence;
	}

	public function getId()
	{
		return $this->idGenerator;
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	/* Finish the setters and getters */

}

?>