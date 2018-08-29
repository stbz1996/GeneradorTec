<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("form");
		$this->load->model("Login_model");
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
		$data["pageName"] = $pageName;
		$data["message"] = $message; 
		$this->load->view("Header", $data);
		$this->load->view("Login/login", $data);
		$this->load->view("Footer");
	}


	/***************************************************
	That function is in charged to check if the user and
	passwors of an admin are registered in BD and takes 
	the user to the HomePage if credential isregistered.   
	***************************************************/
	function checkAdmin()
	{
		// Sent data to model
		$data = array(
			'user' =>  $this->input->post('inputEmail'),
			'password' => $this->input->post('inputPassword')
		); 
		
		// Receive data from model 
		$data['dataAdmin'] = $this->Login_model->checkAdmin($data);

		// Valid data from errors 
		if ($data['dataAdmin'] != false)
		{
			foreach ($data['dataAdmin']->result() as $admin)
			{
				$this->save_username_in_session($admin->userName);
			}
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
		redirect('HomePage_controller/index/');
	}
}
