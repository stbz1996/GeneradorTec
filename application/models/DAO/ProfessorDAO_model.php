<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfessorDAO_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

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
}