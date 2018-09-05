<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_Logic{
	function __construct()
	{}

	/****************************************
	*Function that validates and returns the*
	*information to show in form.	 		*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*										*
	*Result: 								*
	*	Query with the necessary information*
	*****************************************/
	function validateInformation($idForm, $idProfessor)
	{
		$form = new FormDAO_model();
		$result = $form->getInitialInformation($idForm, $idProfessor);

		return $result;	
	}
	
	/****************************************
	*Function that validates and returns the*
	*information of professor's form. 		*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*										*
	*Result: 								*
	*	Query with form's information 		*
	*****************************************/
	function validateForm($idProfessor)
	{
		$form = new FormDAO_model();
		$result = $form->getForm($idProfessor);

		if($result)
		{
			return $result;	
		}
		else
		{
			return false;
		}
		
	}
	/****************************************
	*Function that validates the workload   *
	*entered by the professor.				*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$workload: Integer, possible work- *
	*	load of professor. 					*
	*****************************************/
	function validateWorkload($idProfessor, $workload)
	{
		$form = new FormDAO_model();
		$form->updateWorkload($idProfessor, $workload);
	}

	function validateInsertActivity($idForm, $description, $workPorcent)
	{ 
		try {
			$activityDTO = new ActivityDTO();
			$activityDTO->setDescription($description);
			$activityDTO->setIdForm($idForm);
			$activityDTO->setWorkPorcent($workPorcent);

			$activityDAO = new ActivityDAO_model();
			$activityDAO->insertActivity($activityDTO);
		} catch (Exception $e) {
			return false;
		}
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