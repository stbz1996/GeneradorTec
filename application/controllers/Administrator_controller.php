<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("form");
		//$this->load->model("HomePage_model");
	}

	/***************************************************
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		//$sendData['userName'] = $this->session->flashdata('userName');
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/homePage");
		//$this->call_generateLinks();
		$this->load->view("HomePage/Footer");
	}



	function call_generateLinks(){
		// Receive data from model 
		$data['profesors'] = $this->HomePage_model->findProfesors(); 
		if ($data['profesors'] == false)
		{
			$data['profesors'] = 'No hay registros';
		} 
		$this->load->view("HomePage/generarLinks", $data);
	}
}