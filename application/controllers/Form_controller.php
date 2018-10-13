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

		$this->load->model("DTO/ScheduleDTO");		
		$this->load->model("DAO/ScheduleDAO_model");


		date_default_timezone_set("America/Costa_Rica");
		$this->Form = new FormDTO();
		$this->Form_Logic = new Form_Logic();
	}


	function index()
	{
		//Verify if p value exist
		if(!isset($_GET['p']))
		{
			return;
		}
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

		//Verify if form doesn't exist
		if(!$queryForm)
		{
			return;
		}
		$newForm = $queryForm;
		$this->Form = $this->getFormInformation($newForm);

		//Set global variables
		$this->session->set_userdata('idForm', $this->Form->getIdForm());
		$this->session->set_userdata('idProfessor', $this->Form->getIdProfessor());

		//Get initial information of professor
		$initialInformation = $this->getInitialInformation($this->Form);

		//This condition verify if due date already pass
		if(strtotime(date("Y/m/d")) > strtotime($this->Form->getDueDate()) || !$this->Form->getState())
		{
			return;
		}
		//Assign information to show it in form
		$data = $this->assignInitialInformation($initialInformation);
		$data['dueDate'] = $this->Form->getDueDate();
		$data['extension'] = $this->Form->getExtension();

		//Get saved information
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
		$form->setExtension($newForm->extension);

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
		$saveState = $_POST['saveState'];
		$workload = $_POST['workload'];
		$extension = $_POST['extension'];
		$activitiesDescription = json_decode($_POST['activitiesDescription']);
		$activitiesWorkPorcent = json_decode($_POST['activitiesWorkPorcent']);
		$idCourses = json_decode($_POST['idCourses']);
		$priorities = json_decode($_POST['priorities']);
		$schedules = json_decode($_POST['schedules']);
		$this->validateDataFromView($saveState, $workload, $extension, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities, $schedules);
	}

	/****************************************
	*Function that validate all data form 	*
	*view and save it in database. 			*
	*										*
	*Input:									*
	*	-$saveState: Integer, state to save *
	*	information. (0 = just save, 1 = sa-*
	*	ve and send). 						*
	*	-$workload: Integer, workload assign*
	*	by the professor. 					*
	*	-$activitiesDescription: Array, list*
	*	of description of all activities. 	*
	*	-$activitiesWorkPorcent: Array, list*
	*	of porcent of all activities. 		*
	*	-$idCourses: Array, list of id of 	*
	*	courses chosen by professor.		*
	*	-$priorities: Array, list of priori-*
	*	ty of each course.					*
	*	-$schedules: Array, list of all 	*
	*	schedules chosen by professor.		*
	*****************************************/
	function validateDataFromView($saveState, $workload, $extension, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities, $schedules)
	{
		$idForm = $_SESSION['idForm'];
		$idProfessor = $_SESSION['idProfessor'];
		
		/* Save data (workload, activities, courses and schedules)*/
		$this->insertWorkload($idProfessor, $workload, $extension);
		$this->manageActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
		$this->assignCourses($idForm, $idCourses, $priorities);
		$this->saveScheduleInformation($schedules);

		/* Verify if professor wanna send the information*/
		if($saveState)
			$this->desactivateForm($idForm);

	}

	/****************************************
	*Function that manage all activities 	*
	*created by professor. 		 			*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$activitiesDescription: Array, list*
	*	of description of all activities. 	*
	*	-$activitiesWorkPorcent: Array, list*
	*	of porcent of all activities. 		*
	*****************************************/
	function manageActivities($idForm, $activitiesDescription, $activitiesWorkPorcent)
	{
		//Prepare data
		$oldActivities = $this->getActivities();
		$totalOldActivities = count($oldActivities);
		$totalNewActivities = count($activitiesDescription);

		/* Update old activities with the new information */
		$this->updateActivities($totalOldActivities, $totalNewActivities, $oldActivities, $activitiesWorkPorcent, $activitiesDescription);

		/* Case they are more old activities (activities in DB) than the new ones*/
		if($totalOldActivities >= $totalNewActivities)
		{
			$this->deleteOldActivities($totalOldActivities, $totalNewActivities, $oldActivities);
		}

		/* Case they are more new activities than the old ones (activities in DB)*/
		else if($totalOldActivities < $totalNewActivities)
		{
			$this->insertNewActivities($idForm, $activitiesWorkPorcent, $activitiesDescription, $totalOldActivities);
		}
	}

	/****************************************
	*Function that update activities from DB*
	*										*
	*Input:									*
	*	-$totalOldActivities: Integer, total*
	*	of old activities. 					*
	*	-$totalNewActivities: Integer, total*
	*	of new activities. 					*
	*	-$oldActivities: Array, list of old *
	*	activities stored in DB.			*
	*	-$activitiesDescription: Array, list*
	*	of description of all activities. 	*
	*	-$activitiesWorkPorcent: Array, list*
	*	of porcent of all activities. 		*
	*****************************************/
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
		}

		/* Update the activities in DB */
		if(count($newActivities))
		{
			$this->Form_Logic->updateActivities($newActivities);
		}
	}

	/****************************************
	*Function that delete activities from DB*
	*										*
	*Input:									*
	*	-$totalOldActivities: Integer, total*
	*	of old activities. 					*
	*	-$totalNewActivities: Integer, total*
	*	of new activities. 					*
	*	-$oldActivities: Array, list of old *
	*	activities stored in DB.			*
	*****************************************/
	function deleteOldActivities($totalOldActivities, $totalNewActivities, $oldActivities)
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

	/****************************************
	*Function that insert new activities 	*
	*from DB. 								*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$activitiesWorkPorcent: Array, list*
	*	of porcent of all activities. 		*
	*	-$activitiesDescription: Array, list*
	*	of description of all activities. 	*
	*	-$totalOldActivities: Integer, total*
	*	of old activities. 					*
	*****************************************/
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
	function insertWorkload($idProfessor, $workload, $extension)
	{
		$this->Form_Logic->validateWorkload($idProfessor, $workload, $extension);
	}

	/****************************************
	*Function that insert activities in DB	*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$activitiesWorkPorcent: Array, list*
	*	of porcent of all activities. 		*
	*	-$activitiesDescription: Array, list*
	*	of description of all activities. 	*
	*****************************************/
	function insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent)
	{		
		$totalActivities = count($activitiesDescription);

		/* Create new activityDTO each time and validate it*/
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
		$totalCourses = count($idCourses);
		$courses = array();
		$this->deleteCoursesByForm($idForm);
		if(!$totalCourses)
		{
			return;
		}
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

	function deleteCoursesByForm($idForm)
	{
		$this->Form_Logic->deleteCoursesForm($idForm);
	}

	function desactivateForm($idForm)
	{
		$this->Form_Logic->desactivateForm($idForm);
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
		
		$hoursForView = array();
		$schedulesForView = array();
		
		foreach ($schedules as $schedule) 
		{
			$number = $schedule->numberSchedule;

			if(($number-1) % 6 == 0)
			{
				$hoursForView[] = $schedule->description;
			}

			$dataSchedule['id'] = $schedule->idSchedule;
			$dataSchedule['state'] = $schedule->state;
			$dataSchedule['numberSchedule'] = $number;
			$dataSchedule['description'] = $schedule->description;
			$schedulesForView[] = $dataSchedule;
		}
		$data['hours'] = $hoursForView;
		$data['schedules'] = $schedulesForView;

		return $data;
	
		/*$scheduleCounter = 0;
		foreach ($schedules as $schedule) {
			$hour = $hoursRepresentation[$schedule['initialTime']]; 
			$day = $daysRepresentation[$schedule['dayName']];
			// To accord with the hour and the day, we sent information
			$dataToView[$hour][$day]['day'] = $schedule['dayName'];
			$dataToView[$hour][$day]['initialTime'] = $schedule['initialTime'];
			$dataToView[$hour][$day]['finishTime'] = $schedule['finishTime'];
			$dataToView[$hour][$day]['id']    = $schedule['id'];
			$dataToView[$hour][$day]['state'] = $schedule['state'];

			$scheduleCounter += 1;
		}
		// This variable is used to count the number of schedules in BD
		$this->session->set_userdata('scheduleCounter' , $scheduleCounter);
		$data['hours'] = $hoursRepresentationForView;
		$data['days'] = $dataToView;
		$data['schedules'] = $schedules;

		return $data;*/
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

		if(!count($schedules))
		{
			return false;
		}

		foreach ($schedules as $schedule) 
		{
			$data[] = array(
				'idForm' => $idForm,
				'idSchedule' => $schedule
			);
		}
		$this->Form_Logic->insertScheduleForm($data);
		//$this->showScheduleSelector();
	}
}
?>