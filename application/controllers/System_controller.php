<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("form");
		$this->load->model("DAO/AdministratorDAO_model");
		$this->load->library('Administrator_Logic');
	}


	/***************************************************
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		$this->call_login("Login", "");
	}


	/***************************************************
	That function is in charged to load the login page
	parameters:
		- $pageName: This is the name in the browser.
		- $message: That message is used for errors. 
	***************************************************/
	function call_login($pageName, $message)
	{
		$data["message"] = $message; 
		$this->load->view("Login/Header");
		$this->load->view("Login/login", $data);
		$this->load->view("Login/Footer");
	}


	/***************************************************
	That function is in charged to check if the user and
	passwors of an admin are registered in BD and takes 
	the user to the HomePage if credential isregistered.   
	***************************************************/
	function validCredentials()
	{
		// Conect with logic
		$administrator_Logic = new Administrator_Logic();
		// Get data from view
		$user = $this->input->post('inputEmail');
		$password = $this->input->post('inputPassword');
		// Check if the admin exist 
		$idAdmin = $administrator_Logic->validCredentials($user, $password);
		if ($idAdmin != false)
		{
			// Load he admin carrer
			$idCareer = $administrator_Logic->findAdminCareer($idAdmin);
			$this->save_username_in_session($idAdmin, $idCareer, $user);
			$this->call_home_page();
		} 
		else $this->call_login("Login", "El usuario o la contraseña son incorrectos");
	}


	/***************************************************
	That function load in session variables the id, 
	idCarrer and username of the admin 
	***************************************************/
	function save_username_in_session($pIdAdmin, $pIdCarrer, $pUserName){
		$this->session->set_userdata('idAdmin' , $pIdAdmin);
		$this->session->set_userdata('idCareer', $pIdCarrer);
		$this->session->set_userdata('userName', $pUserName);
	}


	/***************************************************
	That function takes the user to the home page  
	***************************************************/
	function call_home_page()
	{
		redirect('Administrator_controller/index/', $data); 
	}
}