<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GroupDAO_model extends CI_Model {

    var $groupTable = 'ClassGroup';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    /****************************************
    - Get all the groups from the database
    ****************************************/
    public function show()
    {
        $this->db->from($this->groupTable);
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
    - Get a unique group from the database
    ****************************************/
    public function get($pIdGroup)
    {
        $this->db->from($this->periodTable);
        $this->db->where('idGroup', $pIdGroup);
        $query = $this->db->get();
        return $query->row();
    }

    /****************************************
    - Insert the new group in the database.
    ****************************************/
    public function insert($pGroup)
    {
        $group = array(
            'number' => $pGroup->getNumber()
        );

        $this->db->insert($this->groupTable, $group);
        return $this->db->insert_id();
    }

    /****************************************
    - Edit specific group in the database.
    ****************************************/
    public function edit($pGroup)
    {
        // Changes to be saved in the database.
        $changes = array(
            'number' => $pGroup->getNumber()
        );

        $this->db->where('idGroup', $pGroup->getId());
        $query = $this->db->update($this->groupTable, $changes); // Update the values.

        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /****************************************
    - Delete the group in the database.
    ****************************************/
    public function delete($pGroup)
    {
        $this->db->where('idGroup', $pGroup->getId());
        $this->db->delete($this->groupTable);

        /* If a row is affected. */
        if($this->db->affected_rows())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	function getGroup($idGroup)
	{
		$this->db->select('*');
		$this->db->from('ClassGroup');
		$this->db->where('idGroup', $idGroup);
		$query = $this->db->get();

		if($query)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

}