<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanDAO_model extends CI_Model{

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
		$Plan->setState(true);
		$changes = array('state' => $Plan->getState());
		$this->db->where('idPlan', $Plan->getId());
		$this->db->update('Plan', $changes);
	}


	/****************************************
	- Desactivate the plan. 
	****************************************/
	private function desactivatePlan($Plan)
	{
		$Plan->setState(false);
		$changes = array('state' => $Plan->getState());
		$this->db->where('idPlan', $Plan->getId());
		$this->db->update('Plan', $changes);
	}


	/****************************************
	- Insert the new plan in the database.
	****************************************/
	public function insert($Plan)
	{
		/*
		$newPlan = array(
			'idPlan' => $Plan->getId(), 
			'name' => $Plan->getName(), 
			'state' => $Plan->getState(), 
			'idCareer' => $Plan->getIdCareer()
		);
		*/
		$this->db->insert('Plan', $Plan);
	}


	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function edit($Plan)
	{
		$changes = array(
			'name' => $Plan->getName(), 
			'state' => $Plan->getState(), 
			'idCareer' => $Plan->getIdCareer()
		);
		$this->db->where('idPlan', $Plan->getId());
		$this->db->update('Plan', $changes);
	}


	/****************************************
	- Get all the plan in the database
	****************************************/
	public function show($idCareer)
	{
		$this->db->select('*');
		$this->db->from('Plan');

		if ($idCareer != null)
		{
			$this->db->where('idCareer', $idCareer);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}


	/****************************************
	- Delete the plan in the database.
	****************************************/
	public function delete($Plan)
	{
		// Búsqueda recursiva
	}

}