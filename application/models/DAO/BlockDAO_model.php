<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BlockDAO_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	- Insert the new plan in the database.
	****************************************/
	public function insert($Block)
	{
		$this->db->insert('Block', $Block);
        echo 'true';
        return;
	}

	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function edit($Block)
	{
		$changes = array(
			'name' => $Block['name'], 
			'state' => $Block['state'], 
			'idPlan' => $Block['idPlan'] 
		);
		$this->db->where('idBlock', $Block['idBlock']);
		$query = $this->db->update('Block', $changes);
		
        if($query)
        {
            echo 'true';
            return;
        }
        else
        {
            echo 'false';
            return;
        }
	}

	/****************************************
	- Get all the plan in the database
	****************************************/
	public function show($idPlan)
	{
		$this->db->select('*');
		$this->db->from('Block');

		if ($idPlan)
		{
			$this->db->where('idPlan', $idPlan);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query;
		}

		else
		{
			return false;
		}
	}

	/****************************************
	- Get a unique block from the database
	****************************************/
	public function get($id)
    {
        $this->db->from('Block');
        $this->db->where('idBlock', $id);
        $query = $this->db->get();
        return $query->row();
	}
	
	/****************************************
    - Check if there is a unique block associated with a course
    ****************************************/
    private function validateBlockInCourses($pId)
    {
        $this->db->from('Course');
        $this->db->where('idBlock', $pId);
        $query = $this->db->get();
        return $query->num_rows();
    }

	/****************************************
	- Delete the block in the database.
	****************************************/
	public function delete($pId)
	{
		$validateBlockInCourses = $this->validateBlockInCourses($pId);

        if($validateBlockInCourses == 0)
        {
            $this->db->where('idBlock', $pId);
            $this->db->delete('Block');
            echo 'true';
            return;
        }

        else
        {
            echo 'false';
            return;
        }
	}

	/****************************************
	- Activate or desactivate the block.
	****************************************/
	public function changeState($Block)
	{
		$changes = array(
			'state' => $Block['state']
		);
		$this->db->where('idBlock', $Block['idBlock']);
		$this->db->update('Block', $changes);
	}
}