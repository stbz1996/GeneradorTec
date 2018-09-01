<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_Logic{

	function __construct()
	{}

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

 		return $plans;
 	}
}

?>