<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormDAO_model extends CI_Model
{

	var $table = 'Form';
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
	function getForm($hashCode)
	{
		$this->db->select('*');
		$this->db->from('Form');
		$this->db->where('hashCode', $hashCode);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->row();
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
		$this->db->select('Professor.idCareer');
		$this->db->select('Professor.workLoad');
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


	/************************************************
	That function check if there is a form with the 
	respective idProfesor and IdPeriod
	************************************************/
	public function lookForSpecificForm($pForm)
	{
		$this->db->select('idForm');
		$this->db->from('Form');
		$this->db->where('idProfessor', $pForm->getIdProfessor());
		$this->db->where('idPeriod', $pForm->getIdPeriod());
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }		
		if ($query->num_rows() > 0) return true;
		else return false;
	}


	public function createForm($form)
	{
		$newForm = array(
			'hashcode'    => $form->getHashCode() , 
			'state'       => $form->getState() , 
			'dueDate'     => $form->getDueDate() , 
			'idProfessor' => $form->getIdProfessor() ,
			'idPeriod'    => $form->getIdPeriod()
		);
		try{ $query = $this->db->insert('Form', $newForm); }
		catch (Exception $e){ return false; }
		return true;
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
		$this->db->set('Professor.workLoad', (string)$workload);
		$this->db->where('Professor.idProfessor', (string)$idProfessor);
		$this->db->update('Professor');
	}

	/****************************************
	*Function that get the form that belongs 
	* to a professor.				        *
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$idPeriod: Integer, id of actual   *
	*   period. 							*
	*****************************************/
	function getProfessorForm($idProfessor, $idPeriod)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('idProfessor', $idProfessor);
		$this->db->where('idPeriod', $idPeriod); 
		$query = $this->db->get(); 		
		return $query->row();
	}

	/****************************************
	*Function that relate courses assigned  *
	*by the professor and his/her form. 	*
	*										*
	*Input:									*
	*	-$courses: Array($CoursesDTO), cour-*
	* 	ses professor chose. 				*
	*****************************************/
	public function insertCoursesForm($data)
	{
		$this->db->insert_batch('CourseXForm', $data);
	}

	public function deleteCoursesForm($idForm)
	{
		$this->db->where('idForm', $idForm);
		$this->db->delete('CourseXForm');
	}

	public function insertScheduleForm($data)
	{
		$this->db->insert_batch('FormXSchedule', $data);
	}

	public function deleteScheduleForm($idForm)
	{
		$this->db->where('idForm', $idForm);
		$this->db->delete('FormXSchedule');
	}

	public function showScheduleForm($idForm)
	{
		$this->db->select('*');
		$this->db->from('FormXSchedule');
		$this->db->where('idForm', $idForm);

		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function desactivateForm($idForm)
	{
		$changes = array('state' => 0);
		$this->db->where('idForm', $idForm);
		$this->db->update('Form', $changes);
	}
}


?>