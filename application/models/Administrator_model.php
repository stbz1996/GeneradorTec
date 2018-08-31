<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function validCredentials($userName, $password)
	{
		$this->db->select('userName');
		$this->db->from('Administrator');
		$this->db->where('userName', $userName);
		$this->db->where('password', $password);
		$query = $this->db->get();		
		if ($query->num_rows() > 0) return true;
		else return false;
	}

	/****************************************
	- The function returns all admin registered in the database
	****************************************/
	public function getAllAdmin()
	{
		/* Return all the admin in the system.*/
		$query = $this->db->get('Administrator');
		if ($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}

	/****************************************
	- Insert an Admin to the database
	- It just need the username and a password.
	****************************************/
	public function insertAdmin($username, $password)
	{
		$Admin = array('userName' => $username, 'password' => $password);
		$this->db->insert('Administrator', $Admin);
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


