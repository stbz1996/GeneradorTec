<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityDAO_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function insertActivity($activity)
	{
		//$holi = 1;
		$data = array(
			'description' => $activity->getDescription(),
			'idForm' => $activity->getIdForm(),
			'workPorcent' => $activity->getWorkPorcent() 
		);
		$this->db->insert('Activity', $data);
	}
}

?>