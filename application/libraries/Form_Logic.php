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

}

?>