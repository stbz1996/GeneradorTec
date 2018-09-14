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
}

?>