<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeriodDAO_model extends CI_Model {

	var $table = 'Period';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	Returns the active period 
	****************************************/
	function findActivePeriod($PeriodDTO, $pCarrer)
	{
		$this->db->select('idPeriod');
		$this->db->from('Career');
		$this->db->where('idCareer', $pCarrer->getId());
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }
		
		if ($query->num_rows() > 0) {
			$idPeriod = $query->row()->idPeriod;
			$PeriodDTO->setIdPeriod($idPeriod);
		}
		else{
			$PeriodDTO->setIdPeriod(0);
		}

		return $PeriodDTO;
	}


	public function getPeriods()
 	{
 		$this->db->select('*');
		$this->db->from('Period');
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }
		
		if ($query->num_rows() > 0) return $query;
		else return false;
	}
	 
	 /****************************************
    - Get all the periods from the database
    ****************************************/
    public function show()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    /****************************************
    - Get a unique professor from the database
    ****************************************/
    public function get($pId)
    {
        $this->db->from($this->table);
        $this->db->where('idPeriod', $pId);
        $query = $this->db->get();
        return $query->row();
    }

    /****************************************
    - Insert the new period in the database.
    ****************************************/
    public function insert($pPeriod)
    {
        $this->db->insert($this->table, $pPeriod);
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
        $this->db->update($this->table, $changes);
        return $this->db->affected_rows();
    }

    /****************************************
    - Delete the period in the database.
    ****************************************/
    public function delete($pId)
    {
        $this->db->where('idPeriod', $pId);
        $this->db->delete($this->table);
    }

}