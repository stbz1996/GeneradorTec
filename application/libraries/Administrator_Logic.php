<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_Logic{


	function __construct()
	{

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
			$carrer = $result->row();
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
 		return $periodDAO_model->findPeriods();
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
	private function compareUser($data, $Admin)
	{
		for($i = 0; $i < count($data); $i++)
		{
			$tempName = $data[$i]->userName;

			if (strtolower($tempName) == strtolower($Admin->getUser()))
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
	public function isUserInDatabase($query, $Admin)
	{
		$data = array();
		$state = false;

		// If there are not admins.
		if (!$query){
			echo "<script>alert('Hay un problema con su solicitud');</script>";
			return false;
		}

		$data = $query->result();

		$state = $this->compareUser($data, $Admin);

		/* If the new admin username is registered in the database*/
		if (!$state){
			echo "<script>alert('El usuario ya está registrado en el sistema.');</script>";
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
 		$planDAO_model->delete($data);
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
 	public function getArrayCourses($id)
 	{
 		/* Get the blocks from the database */
 		$courseDAO_model = new CourseDAO_model();

 		if ($id == null)
 		{
 			$query = $courseDAO_model->show();
 		}else{
 			$query = $courseDAO_model->showById($id);
 		}
 	
 		if (!$query)
 		{
 			return array();
 		}

 		return $query;
 	}


 	/****************************************
	- Insert a course in the database.
	****************************************/
 	public function insertCourse($data)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->insert($data);
 	}


 	/****************************************
	- Get the information about an unique course.
	****************************************/
 	public function getUniqueCourse($id)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->get($id);
 	}


 	/****************************************
	- Edit the information of a course.
	****************************************/
 	public function editCourse($data)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->edit($data);
 	}


 	/****************************************
	- Delete the information of a course.
	****************************************/
 	public function deleteCourse($id)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->delete($id);
 	}


 	/****************************************
	- Change the state of a course.
	****************************************/
 	public function changeStateCourse($data)
 	{
 		$courseDAO_model = new CourseDAO_model();
 		return $courseDAO_model->changeState($data);
 	}


 	/**************************************************************
	This function returns all the schedules regitered in the sistem
 	***************************************************************/
 	public function getAllSchedules()
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

 	public function updateSchedule($schedule)
 	{
 		$scheduleDAO_model = new ScheduleDAO_model();
 		$scheduleDAO_model->updateScheduleState($schedule);
 	}

}

?>