<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("Form_model");
	}

	function index()
	{
		$this->Form_model->setIdProfessor(1);
		//$this->executeStoredProcedures();
		//$data['dueDate'] = $this->Form_model->get("dueDate");
		//$data['dueDate'] = date("d/m/Y", strtotime($this->Form_model->spGetInformation()->row()->dueDate));
		$result = $this->Form_model->GetInitialInformation()->row();


		$data['dueDate'] = $result->dueDate;
		$data['professorFirstName'] = $result->professorName;
		$data['professorLastName'] = $result->lastName;
		$data['careerName'] = $result->careerName;
		$data['periodNumber'] = $result->number;
		$data['periodYear'] = $result->year;
		$data['formState'] = $result->state;

		$this->load->view("Forms/Header");
		$this->load->view("Forms/Content", $data);
		$this->load->view("Forms/Footer");
	}

	function executeStoredProcedures()
	{
		$this->Form_model->getInitialInformation();
	}



}


?>