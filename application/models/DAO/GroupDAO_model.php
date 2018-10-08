<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GroupDAO_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getGroup($idGroup)
	{
		$this->db->select('*');
		$this->db->from('ClassGroup');
		$this->db->where('idGroup', $idGroup);
		$query = $this->db->get();

		if($query)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

}