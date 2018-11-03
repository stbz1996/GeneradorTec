<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_Logic{


	function __construct()
	{

	}

	/******************************************************************
	Insert a new administrator in the database.
	******************************************************************/
	public function insertAdmin($username, $password, $idCareer)
	{
		$administratorDAO_model = new AdministratorDAO_model();
		$administrator = new AdministratorDTO();
		$administrator->setUser($username);
		$administrator->setPassword($password);
		$administratorDAO_model->insert($administrator, $idCareer);
	}


	/******************************************************************
	That functions returns the idAdministrator if the administratrator
	is registered, if no, returns false
	******************************************************************/
	public function validCredentials($username, $pasword)
	{
		$administratorDAO_model = new AdministratorDAO_model();
		$result = $administratorDAO_model->checkAdmin($username, $pasword);
		if ($result != false ) {
			$admin = $result->row();
			return $admin->idAdministrator;
		}
		return false;
	}


	/*************************************************
	Returns the idCarrer of an admin o returns false
	if the query is empty
	*************************************************/
	public function findAdminCareer($idAdmin)
	{
		$administratorDAO_model = new AdministratorDAO_model();
		$result = $administratorDAO_model->getAdminCareer($idAdmin);
		if ($result != false ) {
			$carrer = $result;
			return $carrer->idCareer;
		}
		return false;
	}


	/*********************************************************************
	That function returns the list of periods in DB
 	*********************************************************************/
 	public function findPeriods()
 	{
 		$periodDAO_model = new PeriodDAO_model();
 		return $periodDAO_model->show();
 	}

 	/*********************************************************************
	That function returns the list of profesors in DB
 	*********************************************************************/
 	public function findProfessors($idCareer)
 	{
 		$professorDAO_model = new ProfessorDAO_model();
 		return $professorDAO_model->findProfessors($idCareer);
	}


	/****************************************
	- Compare the user's name with the new username.
	- $data -> is an array of users in the database.
	- Returns (true/false) if the user is registered.
	****************************************/
	private function compareUser($data, $username)
	{
		for($i = 0; $i < count($data); $i++)
		{
			$tempName = $data[$i]->userName;

			if (strtolower($tempName) == strtolower($username))
			{
				return false;
			}
		}
		return true;
	}


	/****************************************
	- Get all the users in the database and call function compareUser.
	- Returns the result of compareUser.
	****************************************/
	public function isUserInDatabase($username)
	{
		$administratorDAO = new AdministratorDAO_model();
		$data = array();
		$state = false;
		$query = $administratorDAO->show();

		// If there are not admins.
		if (!$query){
			echo 'false';
			return false;
		}

		$data = $query->result();
		$state = $this->compareUser($data, $username);

		/* If the new admin username is registered in the database*/
		if (!$state){
			echo 'false';
			return false;
		}

		return true;
	}


 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayCareers()
 	{
 		/* Get the careers from the database */
 		$careerDAO_model = new careerDAO_model();
 		$query = $careerDAO_model->show();
 		$careers = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		return $data;
 	}


	/****************************************
	- Operations of plans.
	- Show (All)
	- Insert
	- Get (Only unique)
	- Edit
	- Delete
	****************************************/ 	

 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayPlans($id)
 	{
 		/* Get the plans from the database */
 		$planDAO_model = new PlanDAO_model();
 		$query = $planDAO_model->show($id);
 		$plans = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		return $data;
 	}


 	/****************************************
	- Insert a plan in the database.
	****************************************/
 	public function insertPlan($data)
 	{
 		$planDAO_model = new PlanDAO_model();
 		return $planDAO_model->insert($data);
 	}


 	/****************************************
	- Get the information about an unique plan.
	****************************************/
 	public function getUniquePlan($id)
 	{
 		$planDAO_model = new PlanDAO_model();
 		return $planDAO_model->get($id);
 	}

 	/****************************************
	- Get a unique plan with a idBlock.
 	****************************************/
 	public function getPlanFromBlock($idBlock)
	{
		$planDAO_model = new PlanDAO_model();
 		$query = $planDAO_model->getPlanFromBlock($idBlock);
 	
 		if (!$query)
 		{
 			return array();
 		}
 		return $query->row();
	}

 	/****************************************
	- Edit the information of a plan.
	****************************************/
 	public function editPlan($data)
 	{
 		$planDAO_model = new PlanDAO_model();
 		return $planDAO_model->edit($data);
 	}


 	/****************************************
	- Change the state of a plan.
	****************************************/
 	public function changeStatePlan($data)
 	{
 		$planDAO_model = new PlanDAO_model();
 		$planDAO_model->changeState($data);
 	}


 	/****************************************
	- Delete the information of a plan.
	****************************************/
 	public function deletePlan($data)
 	{
 		$planDAO_model = new PlanDAO_model();
 		return $planDAO_model->delete($data);
 	}


 	/****************************************
	- Operations of blocks.
	- Show (All)
	- Insert
	- Get (Only unique)
	- Edit
	- Delete
	****************************************/ 

 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayBlocks($id)
 	{
 		/* Get the blocks from the database */
 		$blockDAO_model = new BlockDAO_model();
 		$query = $blockDAO_model->show($id);
 		$blocks = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		return $data;
 	}


 	/****************************************
	- Insert a block in the database.
	****************************************/
 	public function insertBlock($data)
 	{
 		$blockDAO_model = new BlockDAO_model();
 		return $blockDAO_model->insert($data);
 	}


 	/****************************************
	- Get the information about an unique block.
	****************************************/
 	public function getUniqueBlock($id)
 	{
 		$blockDAO_model = new BlockDAO_model();
 		return $blockDAO_model->get($id);
 	}


 	/****************************************
	- Edit the information of a block.
	****************************************/
 	public function editBlock($data)
 	{
 		$blockDAO_model = new BlockDAO_model();
 		return $blockDAO_model->edit($data);
 	}


 	/****************************************
	- Insert a block in the database.
	****************************************/
 	public function changeStateBlock($data)
 	{
 		$blockDAO_model = new BlockDAO_model();
 		return $blockDAO_model->changeState($data);
 	}


 	/****************************************
	- Delete the information of a block.
	****************************************/
 	public function deleteBlock($data)
 	{
 		$blockDAO_model = new BlockDAO_model();
 		return $blockDAO_model->delete($data);
 	}


 	/****************************************
	- Operations of courses. (Not available for the moment)
	- Show (All)
	- Insert
	- Get (Only unique)
	- Edit
	- Delete
	****************************************/

	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayCourses($pIdBlock)
 	{
 		/* Get the blocks from the database */
 		$courseDAO_model = new CourseDAO_model();

 		$query = $courseDAO_model->show($pIdBlock);

 		if (!$query)
 		{
 			return array();
 		}

 		return $query->result();
 	}

 	/****************************************
	- Convert all activeCourses
	****************************************/
 	public function getActiveCourses()
 	{
 		/* Get the blocks from the database */
 		$courseDAO_model = new CourseDAO_model();

 		$query = $courseDAO_model->getActiveCourses();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		return $query;
 	}


 	/****************************************
	- Insert a course in the database.
	****************************************/
 	public function insertCourse($pData)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->insert($pData);
 	}


 	/****************************************
	- Get the information about an unique course.
	****************************************/
 	public function getUniqueCourse($pId)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->get($pId);
 	}


 	/****************************************
	- Edit the information of a course.
	****************************************/
 	public function editCourse($pData)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->edit($pData);
 	}


 	/****************************************
	- Delete the information of a course.
	****************************************/
 	public function deleteCourse($pId)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->delete($pId);
 	}


 	/****************************************
	- Change the state of a course.
	****************************************/
 	public function changeStateCourse($pData)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->changeState($pData);
 	}

	/****************************************
	- Operations of courses. (Not available for the moment)
	- Show (All)
	- Insert
	- Get (Only unique)
	- Edit
	- Delete
	****************************************/

	/****************************************
	- Convert the data to the database an array.
	****************************************/
	public function getArrayProfessors($pId = null)
	{
		/* Get the professors from the database */
		$professorDAO_model = new ProfessorDAO_model();

		if ($pId == null)
		{
			$query = $professorDAO_model->show();
		}
		
		else
		{
			$query = $professorDAO_model->showByCareer($pId);
		}
	
		if (!$query)
		{
			return array();
		}

		return $query;
	}

	/****************************************
	- Get courses selected by a professor.
	****************************************/
	public function loadSelectCourses($idProfessor, $idPeriod)
	{
		$courseDAO_model = new CourseDAO_model();
		$formDAO_model = new FormDAO_model();

		/* Get the form that belongs to a professor */
		$formQuery = $formDAO_model->getProfessorForm($idProfessor, $idPeriod);
		if (!$formQuery)
		{
			return array();
		}

		$idForm = $formQuery->idForm;
		/* Get the courses that belong to a form. */
		$coursesQuery = $courseDAO_model->getFormCourses($idForm);
		if (!$coursesQuery)
		{
			return array();
		}
		return $coursesQuery->result();
	}

	/****************************************
   - Insert a professor in the database.
   ****************************************/
	public function insertProfessor($pData)
	{
		$professorDAO_model = new ProfessorDAO_model();
		return $professorDAO_model->insert($pData);
	}


	/****************************************
   - Get the information about an unique professor.
   ****************************************/
	public function getUniqueProfessor($pId)
	{
		$professorDAO_model = new ProfessorDAO_model();
		return $professorDAO_model->get($pId);
	}


	/****************************************
   - Edit the information of a professor.
   ****************************************/
	public function editProfessor($pData)
	{
		$professorDAO_model = new ProfessorDAO_model();
		return $professorDAO_model->edit($pData);
	}


	/****************************************
   - Delete the information of a professor.
   ****************************************/
	public function deleteProfessor($pId)
	{
		$professorDAO_model = new ProfessorDAO_model();
		return $professorDAO_model->delete($pId);
	}


	/****************************************
   - Change the state of a professor.
   ****************************************/
	public function changeStateProfessor($pData)
	{
		$professorDAO_model = new ProfessorDAO_model();
		return $professorDAO_model->changeState($pData);
	}

	/****************************************
   - Get all the forms of a professor.
   ****************************************/
	public function getProfessorWithForms($idPeriod)
	{
		$professorDAO_model = new ProfessorDAO_model();
		$activityDAO_model = new ActivityDAO_model();
		$professors = $professorDAO_model->getProfessorsXForms($idPeriod);

		if (!$professors)
		{
			return array();
		}
		
		// For each professor look for the respective activities.
		foreach ($professors as $professor) {
			$idForm = $professor->idForm;
			$result = $activityDAO_model->getPorcentWork($idForm); // Get the activities of a form.
			if (!$result)
			{
				$professor->workPorcent = 0; // Porcent the activities assigned.
				$professor->available = $professor->workLoad;
			}else
			{
				if(!$result[0]->activityPorcent)
				{
					$professor->workPorcent = 0;
				}
				else
				{
					$professor->workPorcent = $result[0]->activityPorcent; // Porcent the activities assigned.
				}

				$professor->available = $professor->workLoad - $professor->workPorcent;

				// If professor doesn't have the enough time.
				if ($professor->available < 0){
					$professor->available = 0;
				}
			}
		}

		return $professors;
	}

	/**************************************************************
	This function returns all the groups registered in the system
 	***************************************************************/
	public function getAllGroups()
	{
		$groupDAO = new GroupDAO_model();
		$query = $groupDAO->show();

		if (!$query)
		{
			return array();
		}
		
		return $query->result();
	}

 	/**************************************************************
	This function returns all the schedules regitered in the sistem
 	***************************************************************/
 	public function getAllSchedules()
 	{
 		$schedules = new ScheduleDAO_model(); 
 		$allSchedules = $schedules->getAllSchedules(); 	
 		return $allSchedules;
 	}


 	public function updateSchedule($schedule)
 	{
 		$scheduleDAO_model = new ScheduleDAO_model();
 		$scheduleDAO_model->updateScheduleState($schedule);
 	}


 	/**************************************************************
	Returns the subject of the email
 	***************************************************************/
 	public function getEmailsubject()
 	{
 		return 'Link para solicitud de cursos TEC';
 	}


 	/**************************************************************
	Receive the name of the profesor, the hash and the date to
	create the message of the email that will be sent to the profesor
 	***************************************************************/
 	public function getEmailMessage($pProfessorName, $pHash, $pSendDate)
 	{
 		$message = "Buenas ".$pProfessorName.". "."Mediante el siguiente link usted podrá ingresar al formulario de solicitud de cursos. Es importante que recuerde que este formulario vence el ".$pSendDate.". El link es el siguiente: ".base_url()."Form/?p=".$pHash;
 		return $message;
 	}


	/****************************************
	- Convert the data to the database an array.
	- Return all the periods and their info in database.
	****************************************/
	public function getArrayPeriods($pId = null)
	{
		/* Get the periods from the database */
		$periodDAO_model = new PeriodDAO_model();

		if ($pId == null)
		{
			$query = $periodDAO_model->show();
		}
	
		if (!$query)
		{
			return array();
		}

		return $query;
	}


	/****************************************
   - Insert a period in the database.
   - Receive the period number and year.
   ****************************************/
	public function insertPeriod($pData)
	{
		$periodDAO_model = new PeriodDAO_model();
		return $periodDAO_model->insert($pData);
	}


	/****************************************
   - Get the information about an unique period.
   - Receive the period id.
   ****************************************/
	public function getUniquePeriod($pId)
	{
		$periodDAO_model = new PeriodDAO_model();
		return $periodDAO_model->get($pId);
	}


	/****************************************
   - Edit the information of a period.
   - Receive the period id, number and year.
   ****************************************/
	public function editPeriod($pData)
	{
		$periodDAO_model = new PeriodDAO_model();
		return $periodDAO_model->edit($pData);
	}


	/****************************************
   - Delete the information of a period.
   - Receive the period id that will be deleted.
   ****************************************/
	public function deletePeriod($pId)
	{
		$periodDAO_model = new PeriodDAO_model();
		return $periodDAO_model->delete($pId);
	}

	public function assignAdvanceDays($data)
	{
		$careerDAO = new careerDAO_model();
		return $careerDAO->assignAdvanceDays($data);
	}

	public function getServiceCourses()
	{
		$courseDAO = new courseDAO_model();
		return $courseDAO->getServiceCourses();
	}
}

?>