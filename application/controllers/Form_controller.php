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
		$this->load->library('System_Logic');

		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO");

		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DTO/ActivityDTO");

		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DTO/CourseDTO");

		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DTO/PlanDTO");

		$this->load->model("DTO/ScheduleDTO");		
		$this->load->model("DAO/ScheduleDAO_model");


		date_default_timezone_set("America/Costa_Rica");
		$this->Form = new FormDTO();
		$this->Form_Logic = new Form_Logic();
		$this->System_Logic = new System_Logic();
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
		$newForm = $queryForm;
		$this->Form = $this->getFormInformation($newForm);
	
		//Set global variables
		$this->session->set_userdata('idForm', $this->Form->getIdForm());
		$this->session->set_userdata('idProfessor', $this->Form->getIdProfessor());

		//Get initial information of professor
		$initialInformation = $this->getInitialInformation($this->Form);

		//This condition verify if due date already pass
		/*if(strtotime(date("Y/m/d")) > strtotime($this->Form->getDueDate()) || !$this->Form->getState())
		{
			return;
		}*/
		//Assign information to show it in form
		$data = $this->assignInitialInformation($initialInformation);
		$data['dueDate'] = $this->Form->getDueDate();

		//Get saved information
		//TODO: Verify if form was saved before
		$data['activities'] = $this->getActivities();
		$idCareer = $initialInformation->idCareer;
		$savedInformation = $this->getSavedInformation($idCareer);
		$data = array_merge($data, $savedInformation);
		$scheduleInformation = $this->showScheduleSelector();
		$data = array_merge($data, $scheduleInformation);
		
		$scheduleForm = $this->showScheduleForm();
		$data = array_merge($data, $scheduleForm);		

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
		/////FUNCIONA
		$workload = $_POST['workload'];
		$activitiesDescription = $_POST['activitiesDescription'];
		$activitiesWorkPorcent = $_POST['activitiesWorkPorcent'];
		$idCourses = $_POST['idCourses'];
		$priorities = $_POST['priorities'];
		$schedules = $_POST['schedules'];
		$this->validateDataFromView($workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities, $schedules);
		
		/*$workload = $this->input->post('workload_options');
		$activitiesDescription = $this->input->post('activityDescription');
		$activitiesWorkPorcent = $this->input->post('workPorcent');
		$idCourses = $this->input->post('idCourses');
		$priorities= $this->input->post('priorities');

		$this->validateDataFromView($workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities);*/
	}

	function validateDataFromView($workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities, $schedules)
	{
		$idForm = $_SESSION['idForm'];
		$idProfessor = $_SESSION['idProfessor'];
		/*$message = $this->Form_Logic->validateDataFromView($idForm, $idProfessor, $workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities);

		if($message !== "")
		{
			echo $message;
		}
		else
		{*/
		$this->insertWorkload($idProfessor, $workload);
		$this->manageActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
		$this->assignCourses($idForm, $idCourses, $priorities);
		$this->saveScheduleInformation($schedules);

			//echo "<script type='text/javascript'>swal('No se puede guardar: Cantidad de cursos es menor a la carga de trabajo asignado', 'hola', 'error');</script>";
		//}		
		//$link = "Form_controller/?p=".$_SESSION['hashCode'];
		//redirect($link, 'refresh');
	}

	function manageActivities($idForm, $activitiesDescription, $activitiesWorkPorcent)
	{
		//Prepare data
		$oldActivities = $this->getActivities();
		$totalOldActivities = count($oldActivities);
		$totalNewActivities = count($activitiesDescription);

		$this->updateActivities($totalOldActivities, $totalNewActivities, $oldActivities, $activitiesWorkPorcent, $activitiesDescription);

		if($totalOldActivities >= $totalNewActivities)
		{
			$this->deleteOldActivities($oldActivities, $totalNewActivities, $totalOldActivities);
		}
		else if($totalOldActivities < $totalNewActivities)
		{
			$this->insertNewActivities($idForm, $activitiesWorkPorcent, $activitiesDescription, $totalOldActivities);
		}
	}

	function updateActivities($totalOldActivities, $totalNewActivities, $oldActivities, $activitiesWorkPorcent, $activitiesDescription)
	{
		$newActivities = array();

		if($totalOldActivities >= $totalNewActivities)
		{
			//Verify if they're new activities
			if(!$totalNewActivities)
			{
				return;
			}

			//Create new activities
			for($i = 0; $i < $totalNewActivities; $i++)
			{
				$newActivity = array(
					'idActivity' => $oldActivities[$i]->getId(),
					'workPorcent' => $activitiesWorkPorcent[$i],
					'description' => $activitiesDescription[$i]
				);
				$newActivities[] = $newActivity;				
			}
		}
		else if($totalOldActivities < $totalNewActivities)
		{
			//Verify if they're old activities
			if(!$totalOldActivities)
			{
				return;
			}

			$updateDescription = array_slice($activitiesDescription, 0, $totalOldActivities);
			$updateWorkPorcent = array_slice($activitiesWorkPorcent, 0, $totalOldActivities);

			//Build array of new activities
			for($i = 0; $i < $totalOldActivities; $i++)
			{
				$newActivity = array(
					'idActivity' => $oldActivities[$i]->getId(),
					'workPorcent' => $updateWorkPorcent[$i],
					'description' => $updateDescription[$i]
				);
				$newActivities[] = $newActivity;				
			}
			$this->Form_Logic->updateActivities($newActivities);
		}
	}

	function deleteOldActivities($oldActivities, $totalNewActivities, $totalOldActivities)
	{
		//Delete the old activities left
		$oldActivities = array_slice($oldActivities, $totalNewActivities);
		if($totalOldActivities > $totalNewActivities)
		{
			$idActivities = array();
			foreach ($oldActivities as $oldActivity) {
				$idActivities[] = $oldActivity->getId();
			}
			$this->Form_Logic->deleteActivities($idActivities);
		}
	}

	function insertNewActivities($idForm, $activitiesWorkPorcent, $activitiesDescription, $totalOldActivities)
	{
		$newDescription = array_slice($activitiesDescription, $totalOldActivities);
		$newWorkPorcent = array_slice($activitiesWorkPorcent, $totalOldActivities);
		$this->insertActivities($idForm, $newDescription, $newWorkPorcent);
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
		$totalActivities = count($activitiesDescription);

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
		$this->deleteCoursesByForm($idForm);
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

	function deleteCoursesByForm($idForm)
	{
		$this->Form_Logic->deleteCoursesForm($idForm);
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

	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function showScheduleSelector()
	{
		// The schedules are loaded
		$schedules = $this->Form_Logic->getAllSchedules();
		
		// Get the data for representation in viw 
		$system_Logic = new System_Logic();
		$hoursRepresentationForView = $system_Logic->getHoursRepresentationForView();
		$daysRepresentation = $system_Logic->getDaysRepresentation();
		$hoursRepresentation = $system_Logic->gethoursRepresentation();
	
		$scheduleCounter = 0;
		foreach ($schedules as $schedule) {
			$hour = $hoursRepresentation[$schedule['initialTime']]; 
			$day = $daysRepresentation[$schedule['dayName']];
			// To accord with the hour and the day, we sent information 
			$dataToView[$hour][$day]['id']    = $schedule['id'];
			$dataToView[$hour][$day]['state'] = $schedule['state']; 
			$scheduleCounter += 1;
		}
		// That varible is used to count the number of schedules in BD
		$this->session->set_userdata('scheduleCounter' , $scheduleCounter);
		$data['hours'] = $hoursRepresentationForView;
		$data['days'] = $dataToView;
		$data['schedules'] = $schedules;

		return $data;
		//$this->callView("SchedulePage", $data);
	}

	public function showScheduleForm()
	{
		$idForm = $_SESSION['idForm'];
		$schedules = $this->Form_Logic->showScheduleForm($idForm);
		$data['formSchedules'] = array();
		if($schedules)
		{
			$data['formSchedules'] = $schedules;
		}
		return $data;
	}

	public function saveScheduleInformation($schedules)
	{
		$idForm = $_SESSION['idForm'];
		$this->Form_Logic->deleteScheduleForm($idForm);
		$data = array();
		foreach ($schedules as $schedule) 
		{
			$data[] = array(
				'idForm' => $idForm,
				'idSchedule' => $schedule
			);
		}
		if(count($data))
		{
			$this->Form_Logic->insertScheduleForm($data);
		}

		// All schedules on DB 
		/*
		$schedules = $this->Form_Logic->getAllSchedules();
		$this->Form_Logic->deleteScheduleForm($idForm);
		foreach ($schedules as $schedule) 
		{
			$idSchedule = $schedule['id'];
			$state = $this->input->post('Inp-'.$idSchedule);	
			// Create the object 
			$data = array();
			if($state)
			{
				$data[] = array(
					'idForm' => $idForm,
					'idSchedule' => $idSchedule
				);
			}
			if(count($data))
			{
				$this->Form_Logic->insertScheduleForm($data);
			}			
			
		}*/
		$this->showScheduleSelector();
	}
}
?>