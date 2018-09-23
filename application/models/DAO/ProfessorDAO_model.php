<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfessorDAO_model extends CI_Model {

    var $table = 'Professor';

	function __construct()
	{
		parent::__construct();
        $this->load->database();
	}
	
	/****************************************
    - Get all the active professors from the database
    ****************************************/
	function findProfessors($idCareer)
	{
		$this->db->select('*');
		$this->db->from('Professor');
		$this->db->where('idCareer', $idCareer);
		$this->db->where('state', "1");
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }
		if ($query->num_rows() > 0) return $query;
		else return false;
	}

	/****************************************
    - Get all the professors from the database
    ****************************************/
    public function show()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    /****************************************
    - Get all the professor that belongs to a specific career.
    ****************************************/
    public function showByCareer($idCareer)
    {
        $this->db->from($this->table);
        $this->db->where('idCareer', $idCareer);
        $query = $this->db->get();
        return $query->result();
    }

    /****************************************
    - Get a unique professor from the database
    ****************************************/
    public function get($id)
    {
        $this->db->from($this->table);
        $this->db->where('idProfessor', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /****************************************
    - Insert the new professor in the database.
    ****************************************/
    public function insert($pProfessor)
    {
        $this->db->insert($this->table, $pProfessor);
        echo 'true';
        return;
    }

    /****************************************
    - Edit all the changes in the database.
    ****************************************/
    public function edit($pProfessor)
    {
        $changes = array(
            'name' => $pProfessor['name'],
            'lastName' => $pProfessor['lastName'],
            'email' => $pProfessor['email']
        );
        $this->db->where('idProfessor', $pProfessor['idProfessor']);
        $query = $this->db->update($this->table, $changes);

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
    - Delete the professor in the database.
    ****************************************/
    public function delete($id)
    {
        $this->db->where('idProfessor', $id);
        $this->db->delete($this->table);
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

    /****************************************
    - Activate or desactivate the professor.
    ****************************************/
    public function changeState($pProfessor)
    {
        $changes = array(
            'state' => $pProfessor['state']
        );
        $this->db->where('idProfessor', $pProfessor['idProfessor']);
        $this->db->update($this->table, $changes);
    }


    /****************************************
    - Returns all the professors with his respective form of a period.
    ****************************************/
    function getProfessorsXForms($idPeriod)
    {
        $this->db->select('Professor.idProfessor');
        $this->db->select('Professor.name');
        $this->db->select('Professor.lastName');
        $this->db->select('Professor.workLoad');
        $this->db->select('Form.idForm');
        $this->db->select('Period.idPeriod');
        $this->db->from('Professor');
        $this->db->join('Form', 'Professor.idProfessor = Form.idProfessor');
        $this->db->join('Period', 'Form.idPeriod = Period.idPeriod');

        $this->db->where('Form.idPeriod', $idPeriod);
        $this->db->where('Professor.state', 1);

        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            
            return $query->result();
        }
        else
        {
            return false;
        }
    }

}