<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper("form");
		$this->load->helper("url");

		$this->load->library('session');
		$this->load->library('Generator_Logic');

		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DTO/BlockDTO");

		$this->Generator_Logic = new Generator_Logic();
	}

	function index()
	{
		$this->fillInfo();
	}

	function fillInfo()
	{
		$totalActiveBlockPlan = $this->Generator_Logic->getTotalActiveBlocks(2);
		echo $totalActiveBlockPlan;
		//Obtener número de bloques activos
		//Por cada bloque, obtener horarios disponibles
		//lista de asignaciones (Clase Magistral)
	}
}

?>