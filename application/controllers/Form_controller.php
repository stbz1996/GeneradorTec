<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$idProfessor = 1;

		$this->load->helper("form");
		$this->load->helper("url");
		$this->load->library('Form_Logic');
		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO_model");


		$this->Form_Logic = new Form_Logic();
		$this->Form = new FormDTO_model();

		$result = $this->Form_Logic->validateForm($idProfessor)->row();
		$this->Form->setIdForm($result->idForm);
		//$this->form->setHashCode($result->hashCode);
		$this->Form->setState($result->state);
		$this->Form->setDueDate($result->dueDate);
		$this->Form->setIdProfessor($idProfessor);
		$this->Form->setIdPeriod($result->idPeriod);


	}

	function index()
	{
		$idProfessor = $this->Form->getIdProfessor();
		$idForm = $this->Form->getIdForm();

		$result = $this->showInitialInformation($idForm, $idProfessor)->row();
		//$result = $this->FormDAO_model->GetInitialInformation()->row();
		
		$data['dueDate'] = $this->Form->getDueDate();
		$data['professorFirstName'] = $result->professorName;
		$data['professorLastName'] = $result->lastName;
		$data['careerName'] = $result->careerName;
		$data['periodNumber'] = $result->number;
		$data['periodYear'] = $result->year;
		$data['formState'] = $this->Form->getState();

		$this->load->view("Forms/Header");
		$this->load->view("Forms/Content", $data);
		$this->load->view("Forms/Footer");

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
		$workload = $this->input->post('workload_options');
		$idProfessor = $this->Form->getIdProfessor();
		
		$this->insertWorkload($idProfessor, $workload);		
		
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



}


?>