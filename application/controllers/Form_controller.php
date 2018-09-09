<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$idProfessor = 5;

		$this->load->helper("form");
		$this->load->helper("url");

		$this->load->library('session');
		$this->load->library('Form_Logic');

		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO");

		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DTO/ActivityDTO");

		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DTO/CourseDTO");

		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DTO/PlanDTO");

		$this->Form = new FormDTO();
		$this->Form_Logic = new Form_Logic();
	}


	function index()
	{
		//Get hashcode of link (p = value)
		$hashCode = $_GET['p'];

		//To store in webpage
		$this->session->set_userdata('idHash' , $hashCode);

		// To consult hashcode $_SESSION['idHash'];
		
		//Get form by hashcode
		$queryForm = $this->Form_Logic->validateForm($hashCode);
		$newForm = $queryForm->row();
		
		//Setting Form
		$this->Form->setIdForm($newForm->idForm);
		$this->Form->setHashCode($hashCode);
		$this->Form->setState($newForm->state);
		$this->Form->setDueDate($newForm->dueDate);
		$this->Form->setIdProfessor($newForm->idProfessor);
		$this->Form->setIdPeriod($newForm->idPeriod);

		$this->session->set_userdata('idForm', $this->Form->getIdForm());

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

		//Get career id
		$idCareer = $initialInformation->idCareer;
		/*  USER STORY 4  */
		$plans = $this->showCareerPlans($idCareer);
		$coursesPlan = $this->showPlanCourses($plans);

		for ($i=0; $i < count($coursesPlan) ; $i++) { 
			if(!count($coursesPlan[$i]))
			{
				unset($plans[$i]);
				unset($coursesPlan[$i]);
			}
		}

		$data['plans'] = array_values($plans);
		$data['courses'] = array_values($coursesPlan);
		/*END USER STORY 4*/

		$this->load->view("Forms/Header");
		$this->load->view("Forms/Content", $data);
		$this->load->view("Forms/Footer");
		
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
		/* USER STORY 2 */


		
		$workload = $this->input->post('workload_options');
		$idProfessor = $this->Form->getIdProfessor();
		
		/* USER STORY 3*/

		
		$activitiesDescription = $this->input->post('activityDescription');

		if ($activitiesDescription) 
		{
			$idForm = $_SESSION['idForm'];
			$activitiesWorkPorcent = $this->input->post('workPorcent');

			//Verify if activity porcent is less than workload
			$totalWorkPorcent = 0;

			foreach ($activitiesWorkPorcent as $workPorcent) {
				$totalWorkPorcent += $workPorcent;
			}

			if($workload >= $totalWorkPorcent)
			{
				$this->insertWorkload($idProfessor, $workload);
				$this->insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
			}
			else
			{
				echo "<script>alert('No se puede guardar: Carga de trabajo es menor al porcentaje de actividades')</script>";
			}
		}
		else
		{
			echo "<script>No se agregaron actividades</script>";
		}
		
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

	function showPlanCourses($plans)
	{	
		$data = array();
		foreach ($plans as $plan) {
			$idPlan = $plan->getId();
			$courses = $this->Form_Logic->getPlanCourses($idPlan);
			$data[] = $courses;
		}

		return $data;
	}

	function showCareerPlans($idCareer)
	{
		return $this->Form_Logic->getCareerPlans($idCareer);
	}


}


?>