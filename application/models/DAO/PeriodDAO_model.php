<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PeriodDAO_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}



	/****************************************
	Returns the active period 
	****************************************/
	function findActivePeriod($PeriodDTO, $pCarrer)
	{
		$this->db->select('idPeriod');
		$this->db->from('Career');
		$this->db->where('idCareer', $pCarrer->getId());
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }
		
		if ($query->num_rows() > 0) {
			$idPeriod = $query->row()->idPeriod;
			$PeriodDTO->setIdPeriod($idPeriod);
		}
		else{
			$PeriodDTO->setIdPeriod(0);
		}

		return $PeriodDTO;
	}


	public function findPeriods()
 	{
 		$this->db->select('*');
		$this->db->from('Period');
		try{ $query = $this->db->get(); }
		catch (Exception $e){ return false; }
		
		if ($query->num_rows() > 0) return $query;
		else return false;
 	}




}