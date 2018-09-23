<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeriodDAO_model extends CI_Model {

    var $periodTable = 'Period';
    var $formTable = 'Form';

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
    - Check if there is a unique period with number and year
    ****************************************/
    private function validatePeriod($pNumber, $pYear)
    {
        $this->db->from($this->periodTable);
        $array = array('number' => $pNumber, 'year' => $pYear);
        $this->db->where($array);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /****************************************
    - Check if there is a unique period associated with a form
    ****************************************/
    private function validatePeriodInForms($pId)
    {
        $this->db->from($this->formTable);
        $this->db->where('idPeriod', $pId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    /****************************************
    - Insert the new period in the database.
    ****************************************/
    public function insert($pPeriod)
    {
        $validate = $this->validatePeriod($pPeriod['number'], $pPeriod['year']);

        if($validate == 0)
        {
            $this->db->insert($this->periodTable, $pPeriod);
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
    - Edit specific period in the database.
    ****************************************/
    public function edit($pPeriod)
    {
        $validatePeriod = $this->validatePeriod($pPeriod['number'], $pPeriod['year']);
        $validatePeriodInForms = $this->validatePeriodInForms($pPeriod['idPeriod']);

        if($validatePeriod == 0 && $validatePeriodInForms == 0)
        {
            $changes = array(
                'number' => $pPeriod['number'],
                'year' => $pPeriod['year']
            );

            $this->db->where('idPeriod', $pPeriod['idPeriod']);
            $this->db->update($this->periodTable, $changes);
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
    - Delete the period in the database.
    ****************************************/
    public function delete($pId)
    {
        $validatePeriodInForms = $this->validatePeriodInForms($pId);

        if($validatePeriodInForms == 0)
        {
            $this->db->where('idPeriod', $pId);
            $this->db->delete($this->periodTable);
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