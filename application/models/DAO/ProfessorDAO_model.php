<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfessorDAO_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function findProfessors(){
		$this->db->select('*');
		$this->db->from('Professor');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) return $query;
		else return false;
	}
}