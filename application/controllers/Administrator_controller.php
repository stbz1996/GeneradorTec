<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->helper("form");
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/AdministratorDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/CourseDAO_model");

		$this->load->model("DAO/PeriodDAO_model");
		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/PeriodDTO");
		$this->load->model("DTO/ProfessorDTO");

		$this->load->model("DTO/AdministratorDTO_model");
		$this->load->model("DTO/PlanDTO_model");
		$this->administrator_logic = new Administrator_Logic();
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


	public function Plans()
	{
		/* Get the plans from the database */
 		$query = $this->PlanDAO_model->show(1);

		$data['plans'] = $this->administrator_logic->getPlans($query);

		$this->load->view("PlanPage/Header");
		$this->load->view("PlanPage/HomePlan", $data);
		$this->load->view("PlanPage/Footer");
	}


	public function editPlan()
	{
		// Edito el plan.
	}

	public function deletePlan()
	{
		// Borro los planes.
	}

	public function changeStatePlan()
	{

	}


	/****************************************
	- That function create the links for the 
	  professors
	****************************************/
	public function generateLinks(){
		// INFORMATION REQUIRED
		$period = $this->PeriodDAO_model->findActivePeriod(new PeriodDTO()); 

		// Find the profesors information
		$data['profesors'] = $this->ProfessorDAO_model->findProfesors();

		if ($data['profesors'] != false)
		{
			// por cada dato del profesor y con el periodo
				// creo la instancia de formulario
				// pregunto el formularioDAO
				// si hay un formulario con ese idProfesor y con ese idPeriodo
					// no creo nada
				// si no lo hay
					// lleno completamente el formulario
					// envio el formulario para que sea creado junto con el hash
		}
		else{
			echo "<script>alert('No hay profesores activos');</script>";
		}

		// Load the view
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
		$autentification = "";
		$state = false;
		$Admin = new AdministratorDTO_model();

		$Admin->setUser($this->input->post('inputUsername'));
		$Admin->setPassword($this->input->post('inputPassword'));
		$autentification = $this->input->post('inputPasswordAgain');

		// If the password are different.
		if ($Admin->getPassword() != $autentification)
		{
			echo "<script>alert('Las contraseñas no coinciden');</script>";
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}
		$query = $this->AdministratorDAO_model->show($Admin);
		$state = $this->administrator_logic->isUserInDatabase($query, $Admin);

		if (!$state)
		{
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}

		$this->AdministratorDAO_model->insert($Admin);

		redirect('Administrator_controller/index/');
		echo "<script>alert('Se ha agregado a la base de datos.');</script>";
	}

	/****************************************
	- Get all courses. Show the view.
	****************************************/
	public function Courses()
	{
		$data['courses'] = $this->CourseDAO_model->getCourses();

		$this->load->view("./HomePage/Header");
		$this->load->view("Admin/Courses", $data);
		$this->load->view("./HomePage/Footer");
	}
}