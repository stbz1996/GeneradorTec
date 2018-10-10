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
		$this->db->order_by('numberSchedule', 'asc');
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }	
		if ($query->num_rows() > 0) return $query->result();
		else return false;
	}


	/**************************************************************
	This function change the state of a schedule
 	***************************************************************/
	public function updateScheduleState($schedule)
	{
		$changes = array('state' => $schedule->getState());
		$this->db->where('numberSchedule', $schedule->getNumberSchedule());
		$this->db->update('Schedule', $changes);
	}


	public function getSchedule($idSchedule)
	{
		$this->db->select('*');
		$this->db->from('Schedule');
		$this->db->where('idSchedule', $idSchedule);
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

	public function getSchedulesByForm($idForm)
	{
		$this->db->select('*');
		$this->db->from('Schedule');
		$this->db->join('FormXSchedule', 'Schedule.idSchedule = FormXSchedule.idSchedule');
		$this->db->where('FormXSchedule.idForm', $idForm);
		$query = $this->db->get();

		if($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

}