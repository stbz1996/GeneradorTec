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
		$this->session->set_userdata('idAdmin' , '');
		$this->session->set_userdata('idCareer', '');
		$this->session->set_userdata('userName', '');
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
		$administrator_Logic = new Administrator_Logic();
		// Get data from view
		$user     = $_POST['username'];
		$password = $_POST['password'];
		// Check if the admin exist 
		$idAdmin = $administrator_Logic->validCredentials($user, $password);
		if ($idAdmin != false)
		{
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
		redirect('Administrator_controller/index/'); 
	}
}