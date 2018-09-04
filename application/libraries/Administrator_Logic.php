<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_Logic{

	private $plans;
	private $actualPlan;

	function __construct()
	{
		$this->plans = array();
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
	- Get all the plans from the database.
	****************************************/
 	public function getPlans($query)
 	{
 		$plans = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		for($i = 0; $i < count($data); $i++)
 		{
 			$plans[$i] = new PlanDTO_model();
 			$plans[$i]->setIdPlan($data[$i]->idPlan);
 			$plans[$i]->setName($data[$i]->name);
 			$plans[$i]->setState($data[$i]->state);
 			$plans[$i]->setIdCareer($data[$i]->idCareer);
 		}

 		$this->plans = $plans;
 		return $plans;
 	}

 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayCareers($query)
 	{
 		$careers = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		for($i = 0; $i < count($data); $i++)
 		{
 			$careers[$i]['ID'] = $data[$i]->idCareer;
 			$careers[$i]['NAME'] = $data[$i]->name;
 		}

 		return $careers;
 	}

 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayPlans($query)
 	{
 		$plans = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		for($i = 0; $i < count($data); $i++)
 		{
 			$plans[$i]['ID'] = $data[$i]->idPlan;
 			$plans[$i]['NAME'] = $data[$i]->name;
 			$plans[$i]['STATE'] = $data[$i]->state;
 		}

 		$this->plans = $plans;
 		return $plans;
 	}


 	

 	/****************************************
	- Convert the data to the database an array.
	****************************************/
 	public function getArrayBlocks($query)
 	{
 		$blocks = array();
 		$data = array();
 	
 		if (!$query)
 		{
 			return array();
 		}

 		$data = $query->result();
 		for($i = 0; $i < count($data); $i++)
 		{
 			$blocks[$i]['ID'] = $data[$i]->idBlock;
 			$blocks[$i]['NAME'] = $data[$i]->name;
 			$blocks[$i]['STATE'] = $data[$i]->state;
 		}

 		return $blocks;
 	}


 	public function printPlans()
 	{
 		for($i = 0; $i < count($this->plans); $i++)
 		{
 			print_r("Plan ");
 			print_r($this->plans[$i]->getName());
 		}
 	}


 	public function getSpecificPlan($idPlan)
 	{
 		for($i = 0; $i < count($this->plans); $i++)
 		{
 			if ($this->plans[$i]->getId() == $idPlan)
 			{
 				return $this->plans[$i];
 			}
 		}
 		return null;
 	}

 	public function getActualPlan()
 	{
 		return $this->actualPlan;
 	}

 	public function setActualPlan($actual)
 	{
 		$this->actualPlan = $actual;
 	}

 	public function setAllPlan($allPlans)
 	{
 		$this->plans = $allPlans;
 	}

 	public function getAllPlan()
 	{
 		return $this->plans;
 	}

}

?>