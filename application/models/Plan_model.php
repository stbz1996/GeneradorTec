<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	- Activate the plan.
	****************************************/
	private function activatePlan($Plan)
	{
		$Plan->state = true;
		$changes = array('state' => $Plan->state);
		$this->db->where('idPlan', $Plan->idPlan);
		$this->db->update('Plan', $changes);
	}

	/****************************************
	- Desactivate the plan. 
	****************************************/
	private function desactivatePlan($Plan)
	{
		$Plan->state = false;
		$changes = array('state' => $Plan->state);
		$this->db->where('idPlan', $Plan->idPlan);
		$this->db->update('Plan', $changes);
	}

	/****************************************
	- Insert the new plan in the database.
	****************************************/
	public function insertPlan($Plan)
	{
		$newPlan = array(
			'idPlan' => $Plan->idPlan, 
			'name' => $Plan->idPlan, 
			'state' => $Plan->state, 
			'idCareer' => $Plan->idCareer
		);
		$this->db->insert('Plan', $newPlan);
	}

	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function editPlan($Plan)
	{
		$changes = array(
			'name' => $Plan->idPlan, 
			'state' => $Plan->state, 
			'idCareer' => $Plan->idCareer
		);
		$this->db->where('idPlan', $Plan->idPlan);
		$this->db->update('Plan', $changes);
	}

	/****************************************
	- Get all the plan in the database
	****************************************/
	public function showPlan()
	{
		/* Return all the plans in the system.*/
		$query = $this->db->get('Plan');
		if ($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}

	/****************************************
	- Delete the plan in the database.
	****************************************/
	public function deletePlan($Plan)
	{
		// Búsqueda recursiva
	}

}