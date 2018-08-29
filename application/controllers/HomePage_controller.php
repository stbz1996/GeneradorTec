<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class HomePage_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		//$this->load->helper("form");
		//$this->load->model("");
	}

	/***************************************************
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		$sendData['userName'] = $this->session->flashdata('userName');
		$sendData['pageName'] = 'Generador';

		$this->load->view("Header", $sendData);
		$this->load->view("HomePage/homePage", $sendData);
		$this->load->view("Footer");
	}
}