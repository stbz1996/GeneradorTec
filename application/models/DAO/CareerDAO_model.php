<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CareerDAO_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	The CRUD Operations are implemented if ... 
	in any moment the developers decide to 
	implements Career operations
	*****************************************
	- Insert the new career in the database.
	****************************************/
	public function insert($Career)
	{
		$newCareer = array(
			'idCareer' => $Career->getId(), 
			'name' => $Career->getName(), 
			'lessonDuration' => $Career->getState(), 
			'advanceDays' => $Career->getAdvanceDays()
		);
		$this->db->insert('Career', $newCareer);
	}

	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function edit($Career)
	{
		$changes = array(
			'name' => $Career->getName(), 
			'lessonDuration' => $Career->getLessonDuration(), 
			'advanceDays' => $Career->getAdvanceDays()
		);
		$this->db->where('idCareer', $Career->getId());
		$this->db->update('Block', $changes);
	}

	/****************************************
	- Get all the careers in the database
	****************************************/
	public function show()
	{
		$this->db->select('*');
		$this->db->from('Career');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}

	/****************************************
	- Delete the career in the database.
	****************************************/
	public function delete($Career)
	{
		// Búsqueda recursiva
	}

	public function assignAdvanceDays($data)
	{
		$this->db->update('Career', $data);
		if($this->db->affected_rows())
		{
			return true;
		}
		return false;
	}

}