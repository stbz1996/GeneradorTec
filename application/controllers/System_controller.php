<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("form");
		$this->load->model("Administrator_model");
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
	function isHeAdmin()
	{
		// Get data from view
		$user = $this->input->post('inputEmail');
		$password = $this->input->post('inputPassword');

		// Receive data from model 
		$result = $this->Administrator_model->validCredentials($user, $password);

		// Valid data from errors 
		if ($result == true)
		{
			$this->save_username_in_session($user);
			$this->call_home_page();
		} 
		else 
		{
			$this->call_login("Login", "El usuario o la contraseña son incorrectos");
		}	
	}


	/***************************************************
	That function load in a variable the username of 
	the admin is the credential are well.  
	***************************************************/
	function save_username_in_session($userName){
		$this->session->set_flashdata('userName', $userName);
	}


	/***************************************************
	That function takes the user to the home page  
	***************************************************/
	function call_home_page()
	{
		redirect('Administrator_controller/index/');
	}
}