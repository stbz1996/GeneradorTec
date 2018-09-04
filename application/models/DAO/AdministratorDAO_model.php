<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdministratorDAO_model extends CI_Model{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	/*************************************************
	Returns the query if there is an administrator
	Returns false if there is no an administrator
	*************************************************/
	public function checkAdmin($userName, $password)
	{
		$this->db->select('idAdministrator');
		$this->db->from('Administrator');
		$this->db->where('userName', $userName);
		$this->db->where('password', $password);
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }	
		if ($query->num_rows() > 0) return $query;
		else return false;
	}


	/*************************************************
	Returns the query with the idCarrer of an admin
	*************************************************/
	public function getAdminCareer($idAdmin)
	{
		$this->db->select('idCareer');
		$this->db->from('AdminXCareer');
		$this->db->where('idAdministrator', $idAdmin);
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }		
		if ($query->num_rows() > 0) return $query;
		else return false;
	}


	/****************************************
	- Insert an Admin to the database
	- It just need the username and a password.
	****************************************/
	public function insert($Admin)
	{
		$newAdmin = array('userName' => $Admin->getUser(), 'password' => $Admin->getPassword());
		$this->db->insert('Administrator', $newAdmin);
	}

	public function edit($Admin)
	{

	}

	public function delete($Admin)
	{

	}

	/****************************************
	- The function returns all admin registered in the database
	****************************************/
	public function show($Admin)
	{
		/* Return all the admin in the system.*/
		$query = $this->db->get('Administrator');
		if ($query->num_rows() > 0){
			return $query;
		}else{
			return false;
		}
	}
}

?>