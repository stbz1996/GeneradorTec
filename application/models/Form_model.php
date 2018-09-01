<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model
{
	private $hashCode;
	private $state;
	private $dueDate;
	private $idProfessor;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function setIdProfessor($pIdProfessor)
	{
		$this->idProfessor = $pIdProfessor;
	}

	public function getIdProfessor()
	{
		return $this->idProfessor;
	}

	public function setDueDate($pDueDate)
	{
		$this->dueDate = $pDueDate;
	}

	public function getDueDate()
	{
		return $this->dueDate;
	}
	
	public function GetInitialInformation()
	{
		$this->db->select('Form.dueDate');
		$this->db->select('Form.state');
		$this->db->select('Professor.name as professorName');
		$this->db->select('Professor.lastName');
		$this->db->select('Career.name as careerName');
		$this->db->select('Period.number');
		$this->db->select('Period.year');

		$this->db->from('Professor');
		$this->db->join('Career', 'Professor.idCareer = Career.idCareer');

		$this->db->from('Form');
		$this->db->join('Period', 'Form.idPeriod = Period.idPeriod');

		$this->db->where('Professor.idProfessor', $this->idProfessor);
		$this->db->where('Form.idProfessor', $this->idProfessor);

		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}
}


?>