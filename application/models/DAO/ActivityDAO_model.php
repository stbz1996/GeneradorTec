<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityDAO_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	*Function that insert activity in DB 	*
	*										*
	*Input:									*
	*	-$activity: ActivityDTO, necessary  *
	*	data to insert activity 			*
	*****************************************/
	function insertActivity($activity)
	{
		$data = array(
			'description' => $activity->getDescription(),
			'idForm' => $activity->getIdForm(),
			'workPorcent' => $activity->getWorkPorcent() 
		);
		$this->db->insert('Activity', $data);
	}

	/****************************************
	*Function that returns query of all ac- *
	*tivities.								*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of Form 		*
	*Result: 								*
	*	Query of all activities 			*
	*****************************************/
	function getActivities($idForm)
	{
		$this->db->select('*');
		$this->db->from('Activity');
		$this->db->where('idForm', $idForm);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	/****************************************
<<<<<<< HEAD
	*Function that updates activities of 	*
	*professor.								*
	*										*
	*Input:									*
	*	-$activities: Array, activities to  *
	*	be updating. 						*
	*****************************************/
	function updateActivities($activities)
	{
		$this->db->update_batch('Activity', $activities, 'idActivity');
	}

	function deleteActivity($idActivity)
	{
		$this->db->where('idActivity', $idActivity);
		$this->db->delete('Activity');
	}

	/*****************************************
	*Function that returns the total porcent of the studies.
	*****************************************/
	function getPorcentWork($idForm)
	{
		$this->db->select('SUM(workPorcent) AS activityPorcent');
		$this->db->from('Activity');
		$this->db->where('idForm', $idForm);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
}

?>