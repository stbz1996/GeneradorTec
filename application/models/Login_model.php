<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function checkAdmin($data)
	{
		$this->db->select('userName');
		$this->db->from('Administrator');
		$this->db->where('userName', $data['user']);
		$this->db->where('password', $data['password']);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) return $query;
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


