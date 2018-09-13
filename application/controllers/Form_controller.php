<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

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
		$this->session->set_userdata('hashCode', $_GET['p']);
		$this->callForm();
	}


	/****************************************
	*Function that get all necessary infor- *
	*mation from database and show it.		*
	*****************************************/
	function callForm()
	{
		$hashCode = $_SESSION['hashCode'];

		//Get form by hashcode
		$queryForm = $this->Form_Logic->validateForm($hashCode);
		$newForm = $queryForm->row();
		$this->Form = $this->getFormInformation($newForm);

		//Set global variables
		$this->session->set_userdata('idForm', $this->Form->getIdForm());
		$this->session->set_userdata('idProfessor', $this->Form->getIdProfessor());

		//Get initial information of professor
		$initialInformation = $this->getInitialInformation($this->Form);

		//Assign information to show it in form
		$data = $this->assignInitialInformation($initialInformation);
		$data['dueDate'] = $this->Form->getDueDate();

		//Get saved information
		//TODO: Verify if form was saved before
		$data['activities'] = $this->getActivities();
		$idCareer = $initialInformation->idCareer;
		$savedInformation = $this->getSavedInformation($idCareer);
		$data = array_merge($data, $savedInformation);
		

		$this->load->view("Forms/Header");
		$this->load->view("Forms/Content", $data);
		$this->load->view("Forms/Footer");
	}


	/****************************************
	*Function that returns a Form object.   *
	*										*
	*Input:									*
	*	-$newForm: Row, information of form	*
	*										*
	*Result: 								*
	*	An object of type form				*
	*****************************************/
	function getFormInformation($newForm)
	{
		$form = new FormDTO();
		$form->setIdForm($newForm->idForm);
		$form->setHashCode($_SESSION['hashCode']);
		$form->setState($newForm->state);
		$form->setDueDate($newForm->dueDate);
		$form->setIdProfessor($newForm->idProfessor);
		$form->setIdPeriod($newForm->idPeriod);

		return $form;
	}


	/****************************************
	*Function that returns an array with i- *
	* nitial information of form. 			*
	*										*
	*Input:									*
	*	-$form: Form, object form of profe-	*
	*	ssor. 								*
	*										*
	*Result: 								*
	*	Array with initial information.		*
	*****************************************/
	function getInitialInformation($form)
	{
		//Get initial information of professor
		$idProfessor = $form->getIdProfessor();
		$idForm = $form->getIdForm();
		$initialInformation = $this->showInitialInformation($idForm, $idProfessor)->row();
		return $initialInformation;
	}


	/****************************************
	*Function that returns an array with i- *
	* nitial information to show in form. 	*
	*										*
	*Input:									*
	*	-$initialInformation: Form, object 	*
	*	form.  								*
	*										*
	*Result: 								*
	*	Array with initial information to	*
	*	show. 								*
	*****************************************/
	function assignInitialInformation($initialInformation)
	{
		$data['professorFirstName'] = $initialInformation->professorName;
		$data['professorLastName'] = $initialInformation->lastName;
		$data['careerName'] = $initialInformation->careerName;
		$data['periodNumber'] = $initialInformation->number;
		$data['workload'] = $initialInformation->workLoad;
		$data['periodYear'] = $initialInformation->year;

		return $data;
	}


	/****************************************
	*Function that returns an array with in-*
	*formation saved by professor. 			*
	*										*
	*Input:									*
	*	-$idCareer: Integer, id of the ca-	*
	*	reer. 								*
	*										*
	*Result: 								*
	*	Array with saved information.		*
	*****************************************/
	function getSavedInformation($idCareer)
	{
		$plans = $this->showCareerPlans($idCareer);
		$coursesPlan = $this->showPlanCourses($plans);

		$data = $this->getFilledPlans($plans, $coursesPlan);
		$coursesForm = $this->getFormCourses();

		$data = array_merge($data, $coursesForm);
	
		return $data;
	}

	/****************************************
	*Function that returns an array of plans*
	*that have courses.			 			*
	*										*
	*Input:									*
	*	-$idCareer: Integer, id of the ca-	*
	*	reer. 								*
	*										*
	*Result: 								*
	*	Array of plans and courses.			*
	*****************************************/
	function getFilledPlans($plans, $coursesPlan)
	{
		for ($i=0; $i < count($coursesPlan) ; $i++) { 

			//Verify if plan doesn't have courses
			if(!count($coursesPlan[$i]))
			{
				unset($plans[$i]);
				unset($coursesPlan[$i]);
			}
		}

		$data['plans'] = array_values($plans);
		$data['courses'] = array_values($coursesPlan);
		return $data;
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
		$activitiesDescription = $this->input->post('activityDescription');
		$activitiesWorkPorcent = $this->input->post('workPorcent');
		$idCourses = $this->input->post('idCourses');
		$priorities= $this->input->post('priorities');

		$this->validateDataFromView($workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities);
	}

	function validateDataFromView($workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities)
	{
		$idForm = $_SESSION['idForm'];
		$idProfessor = $_SESSION['idProfessor'];
		$message = $this->Form_Logic->validateDataFromView($idForm, $idProfessor, $workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities);

		if($message !== "")
		{
			echo $message;
		}
		else
		{
			$this->insertWorkload($idProfessor, $workload);
			$this->insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
			$this->assignCourses($idForm, $idCourses, $priorities);

			echo "<script>
					alert('Datos se ingresaron correctamente');
				  </script>";
		}		
		//$link = "Form_controller/?p=".$_SESSION['hashCode'];
		//redirect($link, 'refresh');
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
		$totalActivities = sizeof($activitiesDescription);

		for($i = 0; $i < $totalActivities; $i++)
		{	
			$activityDTO = new ActivityDTO();

			$activityDTO->setDescription($activitiesDescription[$i]);
			$activityDTO->setIdForm($idForm);
			$activityDTO->setWorkPorcent($activitiesWorkPorcent[$i]);

			$this->Form_Logic->validateInsertActivity($activityDTO);
		}		
	}

	function assignCourses($idForm, $idCourses, $priorities)
	{
		$totalCourses = sizeof($idCourses);
		$courses = array();

		for($i = 0; $i < $totalCourses; $i++)
		{
			$courses[] = array(
				'idCourse' => $idCourses[$i],
				'idForm' => $idForm, 
				'priority' => $priorities[$i],
				'state' => 1
			);
		}
		$this->insertCoursesByForm($courses);
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

	function insertCoursesByForm($courses)
	{
		$this->Form_Logic->insertCoursesForm($courses);
	}

	function getActivities()
	{
		$idForm = $_SESSION['idForm'];
		$activities = $this->Form_Logic->getActivities($idForm);

		if($activities)
		{
			return $activities;
		}
		else
		{
			return array();
		}
	}

	function getFormCourses()
	{
		$idForm = $_SESSION['idForm'];
		$coursesForm = $this->Form_Logic->getFormCourses($idForm);
		
		$data['idCourses'] = array();
		$data['priorities'] = array();
		
		if($coursesForm)
		{
			foreach ($coursesForm as $course) {
				$data['idCourses'][] = $course['idCourse'];
				$data['priorities'][] = $course['priority'];
			}
		}

		return $data;
	}
}
?>