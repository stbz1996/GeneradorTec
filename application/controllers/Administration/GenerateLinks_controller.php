<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class GenerateLinks_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->library('System_Logic');
		$this->load->library('Form_Logic');
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/PeriodDAO_model");
		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO");
		$this->load->helper("form");
		$this->load->library('email');
		$this->administrator_logic = new Administrator_Logic();
		$this->form_Logic          = new Form_Logic();
	}


	/****************************************
	Call and load a view 
	****************************************/
	function callView($viewName, $data)
	{
		$route = "HomePage/".$viewName;
		$this->load->view("HomePage/Header");
		$this->load->view($route, $data);
		$this->load->view("HomePage/Footer");
	}


	/****************************************
	Show an alert with the error and takes 
	the user to the homepage
	*****************************************/
	function showError($pError){
		echo "<script>alert('$pError');</script>";
		$this->callView("homePage", null);
	}


	/****************************************
	- That function create the links for the 
	  professors
	****************************************/
	public function LoadGenerateLinksView()
	{
		$idCareer = $_SESSION['idCareer'];
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		$data['periods']   = $this->administrator_logic->findPeriods(); 
		// If we have proffesors and periods 
		if ($data['profesors'] == true && $data['periods'] == true) {
			$this->callView("GenerateLinks", $data);
			$this->session->set_userdata('LinksState', "");
		}
		// If we have no active proffesors
		if ($data['profesors'] == false)
		{
			$this->showError('No hay profesores activos');
		}
		// If we have no active periods
		if ($data['periods'] == false)
		{
			$this->showError('No hay periodos');
		}
	}


	/***********************************************************
	Create hash of the forms to be sent to the professors
	***********************************************************/
	public function generateLinks()
	{
		// Get data from form 
		$idCareer = $_SESSION['idCareer'];
		$date  = explode("-", $this->input->post('date'));
		$year  = $date[0];
		$month = $date[1];
		$day   = $date[2];
		$sendDate = $year."-".$month."-".$day;
		$dateForEmail = $day."-".$month."-".$year;
		$period   = $this->input->post('period');
		
		// Find active professors
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		$listOfEmailSent = [];
		// Check if the forms are registered or not
		if ($data['profesors'] != false)
		{
			foreach ($data['profesors'] as $p)
			{ 
				$isForRegistered = $this->form_Logic->lookForSpecificForm($p->idProfessor, $period);
				// If the form is not registered 
				if ($isForRegistered == false) 
				{
					$hashCode = $this->form_Logic->createForm($period, $sendDate, $p->idProfessor);
					// send the email if the form was created
					if ($hashCode != false) {
						$professorName = $p->name." ".$p->lastName;
						$email = $p->email;
						$hash = $hashCode;
						$this->sendMailToProfessor($professorName, $email, $hash, $dateForEmail);
						// aqui agrego el nombre del profesor a una lista 
						$listOfEmailSent[] = $professorName;
					}
				}
			}
		}
		else{
			$this->showError('No hay profesores activos');
		}

		$result = 'El correo fue enviado a: ';
		foreach ($listOfEmailSent as $k) {
			$result .= $k.' - ';
		}

		// Call view
		$this->session->set_userdata('LinksState', $result);
		$this->LoadGenerateLinksView();
	}


	/***********************************************************
	Send an email to the 
	***********************************************************/
	public function sendMailToProfessor($pProfessorName, $pEmail, $pHash, $pSendDate)
	{
		$from = 'Test@test.com';
		$fromComplement = 'Administración';
		$subject = $this->administrator_logic->getEmailsubject();
		$message = $this->administrator_logic->getEmailMessage($pProfessorName, $pHash, $pSendDate);
		
		// Fill the email 
		$this->email->from($from, $fromComplement);
		$this->email->to($pEmail);
		$this->email->subject($subject);
		$this->email->message($message);


		//echo "<script>alert('$message');</script>";
		
		/*$res = $this->email->send();
		if ($res == false) 
		{	
			$error = "No se pudo enviar el correo a ".$pProfessorName;
			echo "<script>alert('$error');</script>";
		}
		*/
	}
}