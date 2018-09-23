<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanDAO_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	/****************************************
	- Activate or desactivate the plan.
	****************************************/
	public function changeState($Plan)
	{
		$changes = array(
			'state' => $Plan['state']
		);
		$this->db->where('idPlan', $Plan['idPlan']);
		$this->db->update('Plan', $changes);
	}


	/****************************************
	- Insert the new plan in the database.
	****************************************/
	public function insert($Plan)
	{
		$this->db->insert('Plan', $Plan);
        echo 'true';
        return;
	}


	/****************************************
	- Edit all the changes in the database.
	****************************************/
	public function edit($Plan)
	{
		$changes = array(
			'name' => $Plan['name']
		);
		$this->db->where('idPlan', $Plan['idPlan']);
		$query = $this->db->update('Plan', $changes);

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
	public function show($idCareer)
	{
		$this->db->select('*');
		$this->db->from('Plan');

		if ($idCareer != null)
		{
			$this->db->where('idCareer', $idCareer);
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
	- Get a unique plan from the database
	****************************************/
	public function get($id)
    {
        $this->db->from('Plan');
        $this->db->where('idPlan', $id);
        $query = $this->db->get();
        return $query->row();
    }


	/****************************************
	- Delete the plan in the database.
	****************************************/
	public function delete($Plan)
	{
		$this->db->where('idPlan', $Plan['id']);
		$this->db->delete('Plan');
		
        if($this->db->affected_rows())
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

}