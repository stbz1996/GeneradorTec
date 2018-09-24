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
	public function validateInformation($idForm, $idProfessor)
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
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*										*
	*Result: 								*
	*	Query with form's information 		*
	*****************************************/
	public function validateForm($hashCode)
	{
		$form = new FormDAO_model();
		$result = $form->getForm($hashCode);

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
	public function validateWorkload($idProfessor, $workload)
	{
		$form = new FormDAO_model();
		$form->updateWorkload($idProfessor, $workload);
	}


	/****************************************
	*Function that validates the insert of  *
	*an activity.							*
	*										*
	*Input:									*
	*	-$activity: ActivityDTO, necessary  *
	*	data to insert activity 			*
	*****************************************/
	public function validateInsertActivity($activity)
	{ 
		$activityDAO = new ActivityDAO_model();
		$activityDAO->insertActivity($activity);
	}


// retorna el hash si lo crea bien y false si no lo crea
	public function createForm($pIdPeriod, $pDueDate, $pIdProfessor)
	{
		$form = new FormDTO();
		$form->setHashCode($this->getHash());
		$form->setPeriod($pIdPeriod);
		$form->setState(1);
		$form->setDueDate($pDueDate);
		$form->setIdProfessor($pIdProfessor);
		$formDAO_model = new FormDAO_model();
		if ($formDAO_model->createForm($form) == true) {
			return $form->getHashCode();
		}
		else{
			return false;
		} 
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

	/****************************************
	*Function that get all plans of a career*
	*										*
	*Input:									*
	*	-$pIdCareer: Integer, id of career  *
	*										*
	*Result: 								*
	*	Array of all active plans 	 		*
	*****************************************/
	public function getCareerPlans($pIdCareer)
	{
		$planDAO = new PlanDAO_model();
		$query = $planDAO->show($pIdCareer)->result_array();

		$data = array();

		//Get all active plans
		foreach ($query as $row) {
			if($row['state'])
			{
				$newPlan = new PlanDTO();
				$newPlan->setIdPlan($row['idPlan']);
				$newPlan->setName($row['name']);

				$data[] = $newPlan;
			}
		}
		return $data;
	}
	/****************************************
	*Function that get all courses of a plan*
	*										*
	*Input:									*
	*	-$pIdPlan: Integer, id of a plan    *
	*										*
	*Result: 								*
	*	Array with all the courses  		*
	*****************************************/
	public function getPlanCourses($pIdPlan)
	{
		$courseDAO = new CourseDAO_model();
		$query = $courseDAO->getPlanCourses($pIdPlan)->result_array();

		$data = array();

		//Get all active courses
		foreach ($query as $row) {
			if($row['state'])
			{
				$newCourse = new CourseDTO();
				$newCourse->setIdCourse($row['idCourse']);
				$newCourse->setCode($row['code']);
				$newCourse->setName($row['name']);
				$newCourse->setLessonNumber($row['lessonNumber']);
				$data[] = $newCourse;
			}
		}
		return $data;
	}

	/****************************************
	*Function that relate courses assigned  *
	*by the professor and his/her form. 	*
	*										*
	*Input:									*
	*	-$courses: Array($CoursesDTO), cour-*
	* 	ses professor chose. 				*
	*****************************************/
	public function insertCoursesForm($courses)
	{
		$formDAO = new FormDAO_model();
		$formDAO->insertCoursesForm($courses);
	}

	/****************************************
	*Function that returns array of all ac- *
	*tivities.								*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of Form 		*
	*****************************************/
	public function getActivities($idForm)
	{
		$activityDAO = new ActivityDAO_model();
		$query = $activityDAO->getActivities($idForm);

		//Verify if return rows
		if($query)
		{
			$query = $query->result_array();
			$data = array();

			//Get all activities from form
			foreach ($query as $row) {
				$newActivity = new ActivityDTO();
				$newActivity->setIdActivity($row['idActivity']);
				$newActivity->setIdForm($row['idForm']);
				$newActivity->setDescription($row['description']);
				$newActivity->setWorkPorcent($row['workPorcent']);
				$data[] = $newActivity;
			}
			return $data;
		}
		else
		{
			return false;
		}
	}

	/****************************************
	*Function that returns array of courses *
	*assigned by professor.					*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of Form 		*
	*Result: 								*
	* 	Array with all courses assigned by  *
	*	professor. 							*
	*****************************************/
	public function getFormCourses($idForm)
	{
		$courseDAO = new CourseDAO_model();
		$query = $courseDAO->getFormCourses($idForm);

		//Verify if return rows
		if($query)
		{
			//Get necessary information of courses related to form
			$query = $query->result_array();
			$data = array();
			foreach ($query as $row) {
				$data[] = array(
					'idCourse' => $row['idCourse'],
					'priority' => $row['priority']
				);
			}
			return $data;
		}
		else
		{
			return false;
		}
	}


	function validateDataFromView($idForm, $idProfessor, $workload, $activitiesDescription, $activitiesWorkPorcent, $idCourses, $priorities)
	{
		$message = "";

		$message = $this->verifyAssignCourses($idCourses, $workload);
		if($message !== "")
		{
			return $message;
		}

		$message = $this->verifyActivities($activitiesDescription, $activitiesWorkPorcent, $workload, $idForm);
		return $message;
	}

	function verifyAssignCourses($idCourses, $workload)
	{
		//Verify if professor assigned courses
		if(!$idCourses)
		{
			return "<script>alert('No se puede guardar: No asignó cursos');</script>";
		}

		//Verify if courses assigned are less than workload
		else if(sizeof($idCourses) < $workload / 25)
		{
			return "<script>alert('No se puede guardar: Cantidad de cursos es menor a la carga de trabajo asignado');</script>";
		}
		else
		{
			return "";
		}
	}

	function verifyActivities($activitiesDescription, $activitiesWorkPorcent, $workload, $idForm)
	{
		//Verify if professor add activities
		if($activitiesDescription)
		{
			//Get total porcent of activities
			$totalWorkPorcent = 0;
			foreach ($activitiesWorkPorcent as $workPorcent) {
				$totalWorkPorcent += $workPorcent;
			}

			//Verify if porcent of activities is less than workload
			if($workload >= $totalWorkPorcent)
			{
				//Verify if there's an activity without description
				if(in_array("", $activitiesDescription))
				{
					return "<script>alert('No se puede guardar: Una o varias actividades no poseen datos correctos');</script>";
				}
			}
			else
			{
				return "<script>alert('No se puede guardar: Carga de trabajo es menor al porcentaje total de actividades');</script>";
			}
		}

		return "";
	}

	function updateActivities($activities)
	{
		$activityDAO = new ActivityDAO_model();
		$activityDAO->updateActivities($activities);
	}

	function deleteActivities($idActivities)
	{
		$activityDAO = new ActivityDAO_model();
		for($i = 0; $i < count($idActivities); $i++)
		{
			$activityDAO->deleteActivity($idActivities[$i]);
		}
	}

	function deleteCoursesForm($idForm)
	{
		$formDAO = new FormDAO_model();
		$formDAO->deleteCoursesForm($idForm);
	}

	/**************************************************************
	This function returns all the schedules registered in the system
 	***************************************************************/
 	function getAllSchedules()
 	{
 		$schedules = new ScheduleDAO_model(); 
 		$allSchedules = $schedules->getAllSchedules(); 	
 		foreach ($allSchedules->result() as $schedule) {
 			$arr['id'] = $schedule->idSchedule;
 			$arr['dayName'] = $schedule->dayName;
 			$arr['initialTime'] = $schedule->initialTime;
 			$arr['finishTime'] = $schedule->finishTime;
 			$arr['state'] = $schedule->state;
  			$res[] = $arr;
 		}
 		return $res;
 	}

 	function insertScheduleForm($data)
 	{
 		$formDAO = new FormDAO_model();
 		$formDAO->insertScheduleForm($data);
 	}

 	function deleteScheduleForm($idForm)
 	{
 		$formDAO = new FormDAO_model();
 		$formDAO->deleteScheduleForm($idForm);
 	}

 	function showScheduleForm($idForm)
 	{
 		$formDAO = new FormDAO_model();
 		$query = $formDAO->showScheduleForm($idForm);

 		if(!$query)
 		{
 			return false;
 		}
 		$schedules = array();
 		foreach ($query as $schedule) 
 		{
 			$schedules[] = $schedule['idSchedule'];
 		}

 		return $schedules;
 	}

 	function desactivateForm($idForm)
 	{
 		$formDAO = new FormDAO_model();
 		$formDAO->desactivateForm($idForm);
 	}
}

?>