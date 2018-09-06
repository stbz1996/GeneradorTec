<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$idProfessor = 5;

		$this->load->helper("form");
		$this->load->helper("url");
		$this->load->library('Form_Logic');
		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO");

		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DTO/ActivityDTO");

		$this->Form_Logic = new Form_Logic();
		$this->Form = new FormDTO();

		


	}

	function index()
	{
		//Get hashcode of link (p = value)
		$hashCode = $_GET['p'];

		//Get form by hashcode
		$queryForm = $this->Form_Logic->validateForm($hashCode);

		//Verify if form exist
		if($queryForm)
		{
			$newForm = $queryForm->row();
			//Setting Form
			$this->Form->setIdForm($newForm->idForm);
			$this->Form->setHashCode($hashCode);
			$this->Form->setState($newForm->state);
			$this->Form->setDueDate($newForm->dueDate);
			$this->Form->setIdProfessor($newForm->idProfessor);
			$this->Form->setIdPeriod($newForm->idPeriod);

			//Get initial information of professor
			$idProfessor = $this->Form->getIdProfessor();
			$idForm = $this->Form->getIdForm();

			$initialInformation = $this->showInitialInformation($idForm, $idProfessor)->row();
			
			//Assign information to show it in Form
			$data['dueDate'] = $this->Form->getDueDate();
			$data['professorFirstName'] = $initialInformation->professorName;
			$data['professorLastName'] = $initialInformation->lastName;
			$data['careerName'] = $initialInformation->careerName;
			$data['periodNumber'] = $initialInformation->number;
			$data['periodYear'] = $initialInformation->year;
			$data['formState'] = $this->Form->getState();

			$this->load->view("Forms/Header");
			$this->load->view("Forms/Content", $data);
			$this->load->view("Forms/Footer");

		}

		else
		{
			echo "Error: No se encontró información";
		}
	
		//$cod = $_GET['p'];

		//echo "<script>alert('$cod');</script>";
	}


	/****************************************
	*Function that returns the initial in-	*
	*formation of the form 		 			*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor.								*
	*										*
	*Result: 								*
	*	Initial information to show it in 	*
	*	form.								*
	*****************************************/

	function showInitialInformation($idForm, $idProfessor)
	{
		return $this->Form_Logic->validateInformation($idForm, $idProfessor);
	}

	/****************************************
	*Function that get all values from view *
	*****************************************/
	function getDataFromView()
	{
		/*
		User story 2

		$workload = $this->input->post('workload_options');
		$idProfessor = $this->Form->getIdProfessor();
		
		$this->insertWorkload($idProfessor, $workload);

		*/

		/* User story 3*/



		/*$activitiesDescription = $this->input->post('activityDescription');

		if ($activitiesDescription) 
		{
			$activitiesWorkPorcent = $this->input->post('workPorcent');
			$idForm = $this->Form->getIdForm();
			$this->insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
		}
		else
		{
			echo "<script>alert(0)</script>";
		}*/

		$activitiesDescription = $this->input->post('activityDescription');
		$activitiesWorkPorcent = $this->input->post('workPorcent');
		$idForm = $this->Form->getIdForm();

		$this->insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
	}

	/****************************************
	*Function that insert workload of a pro-*
	*fessor.			 		 			*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$workload: Integer, possible work-	*
	*	load assigned by the professor.		*
	*****************************************/
	function insertWorkload($idProfessor, $workload)
	{
		$this->Form_Logic->validateWorkload($idProfessor, $workload);
	}

	function insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent)
	{
		//$descriptions = array('Coordinador Carrera', 'Proyecto Investigación', 'Coordinador Práctica');
		//$workPorcents = array(30, 20, 30);
		
		$totalActivities = sizeof($activitiesDescription);

		for($i = 0; $i < $totalActivities; $i++)
		{	
			$activityDescription = $activitiesDescription[$i];
			$activityWorkPorcent = $activitiesWorkPorcent[$i];
			$this->Form_Logic->validateInsertActivity($idForm, $activityDescription, $activityWorkPorcent);
		}
		/*for ($i = 0; $i < 3; $i++ ) {
			$this->Form_Logic->validateInsertActivity($descriptions[$i], 3, $workPorcents[$i]);
		}*/
		
	}


}


?>