<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	
	function validCredentials($userName, $password)
	{
		$this->db->select('userName');
		$this->db->from('Administrator');
		$this->db->where('userName', $userName);
		$this->db->where('password', $password);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) return true;
		else return false;
	}
}

// insertar
		/* 
		$this->db->insert('Administrator', array('userName'=>$data['user'], 'password'=>$data['password'])); 
		*/ 
		/*
		$query = $this->db->get_where('Administrator', array('userName'=>$data['user'], 'password'=>$data['password'])); 
		*/
?>


