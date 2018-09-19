<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeriodDAO_model extends CI_Model {

	var $periodTable = 'Period'; // Table name 

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	 /****************************************
    - Get all the periods from the database
    ****************************************/
    public function show()
    {
        $this->db->from($this->periodTable);
        $query = $this->db->get();
        return $query->result();
    }
    

    /****************************************
    - Get a unique period from the database
    ****************************************/
    public function get($pId)
    {
        $this->db->from($this->periodTable);
        $this->db->where('idPeriod', $pId);
        $query = $this->db->get();
        return $query->row();
    }

    /****************************************
    - Insert the new period in the database.
    ****************************************/
    public function insert($pPeriod)
    {
        $this->db->insert($this->periodTable, $pPeriod);
        return $this->db->insert_id();
    }

    /****************************************
    - Edit specific period in the database.
    ****************************************/
    public function edit($pPeriod)
    {
        $changes = array(
            'number' => $pPeriod['number'],
            'year' => $pPeriod['year']
        );
        $this->db->where('idPeriod', $pPeriod['idPeriod']);
        $this->db->update($this->periodTable, $changes);
        return $this->db->affected_rows();
    }


    /****************************************
    - Delete the period in the database.
    ****************************************/
    public function delete($pId)
    {
        $this->db->where('idPeriod', $pId);
        $this->db->delete($this->periodTable);
    }

}