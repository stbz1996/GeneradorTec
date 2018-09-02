<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeriodDAO_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}



	/****************************************
	Returns all the periods in the system.
	****************************************/
	function findActivePeriod($PeriodDTO)
	{
		/*$this->db->select('idProfessor');
		$this->db->select('name');
		$this->db->select('lastName');
		$this->db->select('email');
		$this->db->from('Professor');
		$this->db->where('state', 1);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) return $query;
		else return false;
		*/
		$PeriodDTO->setIdPeriod(1);
		return $PeriodDTO;
	}
}