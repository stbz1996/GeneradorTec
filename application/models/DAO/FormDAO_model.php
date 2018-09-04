<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormDAO_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/****************************************
	*Function that returns form data from DB*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*										*
	*Result: 								*
	*	Query with form's information 		*
	*****************************************/
	function getForm($idProfessor)
	{
		$this->db->select('*');
		$this->db->from('Form');
		$this->db->where('idProfessor', $idProfessor);
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
	*Function that returns information to 	*
	*show it in form.						*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$idForm: Integer, id of form. 		*
	*										*
	*Result: 								*
	*	Query with form's information 		*
	*****************************************/	
	function getInitialInformation($idForm, $idProfessor)
	{


		$this->db->select('Professor.name as professorName');
		$this->db->select('Professor.lastName');
		$this->db->select('Career.name as careerName');
		$this->db->select('Period.number');
		$this->db->select('Period.year');

		$this->db->from('Professor');
		$this->db->join('Career', 'Professor.idCareer = Career.idCareer');

		$this->db->from('Form');
		$this->db->join('Period', 'Form.idPeriod = Period.idPeriod');

		$this->db->where('Professor.idProfessor', $idProfessor);
		$this->db->where('Form.idForm', $idForm);

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
	*Function that updates workload of pro-	*
	*fessor.								*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$workload: Integer, possible amount*
	*	of work.							*
	*****************************************/
	function updateWorkload($idProfessor, $workload)
	{
		$this->db->set('Professor.workLoad', (string)$workload, false);
		$this->db->where('Professor.idProfessor', (string)$idProfessor);
		$this->db->update('Professor');
	}
}


?>