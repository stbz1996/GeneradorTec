<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_Logic{
	function __construct()
	{
		// Functions....
	}


	public function createForm($pIdPeriod, $pDueDate, $pIdProfessor)
	{
		$form = new FormDTO();
		$form->setHashCode($this->getHash());
		$form->setPeriod($pIdPeriod);
		$form->setState(1);
		$form->setDueDate($pDueDate);
		$form->setIdProfessor($pIdProfessor);
		$formDAO_model = new FormDAO_model();
		return $formDAO_model->createForm($form);
	}


	/************************************************
	That function check if there is a form with the 
	respective idProfesor and IdPeriod
	************************************************/
	public function lookForSpecificForm($pIdProfesor, $pIdPeriod)
 	{
		$form = new FormDTO(); 
		$form->setIdProfessor($pIdProfesor);
		$form->setPeriod($pIdPeriod); 
		$form_Logic = new FormDAO_model();
 		return $form_Logic->lookForSpecificForm($form);
 	}

 	/****************************************
	- That function create a hash code using the date
	and the time in miliseconds
	****************************************/
	public function getHash()
	{
		list($usec, $sec) = explode(" ", microtime());
		$miliseconds = ((float)$usec + (float)$sec);
		$date = getdate();
		$hash = $miliseconds.$date["year"].$date["mon"].$date["mday"].$date["minutes"];
    	return $hash;
	}
}

?>