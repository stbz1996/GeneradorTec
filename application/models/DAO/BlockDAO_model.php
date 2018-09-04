<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BlockDAO_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	- Activate the plan.
	****************************************/
	private function activateBlock($Block)
	{
		$Block->setState(true);
		$changes = array('state' => $Block->getState());
		$this->db->where('idBlock', $Block->getId());
		$this->db->update('Block', $changes);
	}

	/****************************************
	- Desactivate the plan. 
	****************************************/
	private function desactivateBlock($Block)
	{
		$Block->setState(false);
		$changes = array('state' => $Block->getState());
		$this->db->where('idBlock', $Block->getId());
		$this->db->update('Block', $changes);
	}

	/****************************************
	- Insert the new plan in the database.
	****************************************/
	public function insert($Block)
	{
		$newBlock = array(
			'idBlock' => $Block->getId(), 
			'name' => $Block->getName(), 
			'state' => $Block->getState(), 
			'idPlan' => $Block->getIdPlan()
		);
		$this->db->insert('Block', $newBlock);
	}

	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function edit($Block)
	{
		$changes = array(
			'name' => $Block->getName(), 
			'state' => $Block->getState(), 
			'idBlock' => $Block->getIdPlan()
		);
		$this->db->where('idBlock', $Block->getId());
		$this->db->update('Block', $changes);
	}

	/****************************************
	- Get all the plan in the database
	****************************************/
	public function show($idPlan)
	{
		$this->db->select('*');
		$this->db->from('Block');
		$this->db->where('idPlan', $idPlan);
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
	public function delete($Block)
	{
		// Búsqueda recursiva
	}

}