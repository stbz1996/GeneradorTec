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
	- Get a list of plan that has the same idBlock.
	****************************************/
	public function getPlanFromBlock($idBlock)
	{
		$this->db->select('Plan.idPlan');
		$this->db->select('Plan.name');
		$this->db->from('Plan');
		$this->db->join('Block', 'Plan.idPlan = Block.idPlan');

		if ($idBlock)
		{
			$this->db->where('Block.idBlock', $idBlock);
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
    - Check if there is a unique plan associated with information in database
    ****************************************/
    private function validatePlan($pId)
    {
        $this->db->from('Block');
        $this->db->where('idPlan', $pId);
        $query = $this->db->get();
        return $query->num_rows();
    }

	/****************************************
	- Delete the plan in the database.
	****************************************/
	public function delete($pId)
	{
		$validatePlan = $this->validatePlan($pId);

        if($validatePlan == 0)
        {
            $this->db->where('idPlan', $pId);
            $this->db->delete('Plan');
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