<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScheduleDAO_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	/**************************************************************
	This function returns all the schedules regitered in the sistem
 	***************************************************************/
	public function getAllSchedules()
	{
		$this->db->select('*');
		$this->db->from('Schedule');
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }	
		if ($query->num_rows() > 0) return $query;
		else return false;
	}


	/**************************************************************
	This function change the state of a schedule
 	***************************************************************/
	public function updateScheduleState($schedule)
	{
		$changes = array('state' => $schedule->getState());
		$this->db->where('idSchedule', $schedule->getId());
		$this->db->update('Schedule', $changes);
	}

}