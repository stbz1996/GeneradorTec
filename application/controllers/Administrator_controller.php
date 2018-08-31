<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper("form");
		$this->load->model("Profesors_model");
		$this->load->model("Administrator_model");
	}

	/****************************************
	- Compare the user's name with the new username.
	- $data -> is an array of users in the database.
	- Returns (true/false) if the user is registered.
	****************************************/
	private function compareUser($data, $newUser)
	{
		for($i = 0; $i < count($data); $i++)
		{
			$tempName = $data[$i]->userName;

			if (strtolower($tempName) == strtolower($newUser))
			{
				return false;
			}
		}
		return true;
	}

	/****************************************
	- Get all the users in the database and call function compareUser.
	- Returns the result of compareUser.
	****************************************/
	private function isUserInDatabase($newUser)
	{
		$query = array();
		$data = array();
		$state = false;
		/* Get all the Admin registers in the database. */
		$query = $this->Administrator_model->getAllAdmin();

		// If there are not admins.
		if (!$query){
			echo "<script>alert('Hay un problema con su solicitud');</script>";
			return false;
		}

		$data = $query->result();

		$state = $this->compareUser($data, $newUser);

		/* If the new admin username is registered in the database*/
		if (!$state){
			echo "<script>alert('El usuario ya está registrado en el sistema.');</script>";
			return false;
		}

		return true;
	}

	/***************************************************
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		//$sendData['userName'] = $this->session->flashdata('userName');
		$this->load->view("HomePage/Header");
		//$this->load->view("HomePage/homePage");
		//$this->call_generateLinks();
		$this->load->view("HomePage/Footer");
	}

	function call_generateLinks(){
		// Receive data from model 
		$data['profesors'] = $this->Profesors_model->findProfesors(); 
		if ($data['profesors'] == false)
		{
			$data['profesors'] = 'No hay registros';
		}
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/generarLinks", $data);
		$this->load->view("HomePage/Footer");
	}

	/****************************************
	- Add a new admin. Show the view.
	****************************************/
	public function AddAdmin()
	{
		$data['pageName'] = "Add a new admin";
		$this->load->view("Admin/Header");
		$this->load->view("Admin/addAdmin", $data);
		$this->load->view("Admin/Footer");
	}

	/****************************************
	- Get the data of the new administrator and compare with the database.
	- If there's no admin with the username, add the new one.
	****************************************/
	public function getAdminData()
	{
		$newUser = "";
		$password = "";
		$autentification = "";
		$state = false;

		$newUser = $this->input->post('inputUsername');
		$password = $this->input->post('inputPassword');
		$autentification = $this->input->post('inputPasswordAgain');

		// If the password are different.
		if ($password != $autentification)
		{
			echo "<script>alert('Las contraseñas no coinciden');</script>";
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}

		$state = $this->isUserInDatabase($newUser);

		if (!$state)
		{
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}

		$this->Administrator_model->insertAdmin($newUser, $password);

		echo "<script>alert('Se ha agregado a la base de datos.');</script>";
		redirect('Administrator_controller/index/');
	}
}