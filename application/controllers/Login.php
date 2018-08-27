<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper("form");	
	}

	function index()
	{
		$this->load->view("Header");
		$this->load->view("Login/login");
		$this->load->view("Footer");
	}

	function LoginRespuesta(){
		$dato["string"] = "jaja nonono";
		$this->load->view("Header");
		$this->load->view("welcome_message", $dato);
		$this->load->view("Footer");
	}

}