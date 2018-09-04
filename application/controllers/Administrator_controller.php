<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller {


	var $data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');

		$this->load->helper("functions_helper");

		$this->load->library('Form_Logic');
		$this->load->helper("form");
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/AdministratorDAO_model");
		$this->load->model("DAO/CareerDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/PeriodDAO_model");
		$this->load->model("DAO/FormDAO_model");

		$this->load->model("DTO/PeriodDTO");
		$this->load->model("DTO/ProfessorDTO");
		$this->load->model("DTO/FormDTO");
		$this->load->model("DTO/CareerDTO");
		$this->load->model("DTO/AdministratorDTO");
		$this->load->model("DTO/PlanDTO");

		$this->administrator_logic = new Administrator_Logic();
		$this->form_Logic = new Form_Logic();
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

	public function Careers()
	{
		/* Get the careers from the database */
 		$query = $this->CareerDAO_model->show();

		$data['listElement'] = $this->administrator_logic->getArrayCareers($query);
		$data['iters'] = getBreadCrumbHome();
		$data['actual'] = "Carreras";
		$data['ADD'] = getAddressCareers();
		$data['STATE'] = stateNoValid();

		$this->load->view("PlanPage/Header");
		$this->load->view("PlanPage/HomePlan", $data);
		$this->load->view("PlanPage/Footer");	
	}


	public function Plans($id = null, $name = null)
	{
		/* Get the plans from the database */
 		$query = $this->PlanDAO_model->show($id);
 		if ($name == null){
 			$data['actual'] = "planes";
 		}else{
 			$data['actual'] = urldecode($name);
 		}

		$data['listElement'] = $this->administrator_logic->getArrayPlans($query);
		$data['iters'] = getBreadCrumbCareer();
		$data['ADD'] = getAddressPlans();
		$data['STATE'] = stateValid();

		$this->load->view("PlanPage/Header");
		$this->load->view("PlanPage/HomePlan", $data);
		$this->load->view("PlanPage/Footer");
	}

	public function addPlan()
	{
		// Comunico a la bd.
		$data = array(
			'name' => $this->input->post('inputName'),
			'state' => false,
			'idCareer' => 1
		);

        $insert = $this->PlanDAO_model->insert($data);
        validateModal();
	}

	public function editPlan($idPlan = null, $name = null)
	{
		if (!$idPlan){
			return;
		}

		$data['pastName'] = $name;
		$data['id'] = $idPlan;
		// Cargo la vista...

		$this->load->view("Admin/Header");
		$this->load->view("PlanPage/EditPlan",$data);
		$this->load->view("Admin/Footer");
	}

	/* Esto se va a eliminar cuando Randy logré sus respectivos avances.*/
	public function editPlan2()
	{
		// Comunico a la BD con el nuevo nombre.
		$newName = $this->input->post('newName');
		$id = $this->input->post('id');
		print_r($newName);
		print_r($id);
		if (!$newName){
			return;
		}

		$Plan = new PlanDTO_model();
		$Plan->setIdPlan($id);
		$Plan->setName($newName);
		$Plan->setState(true);
		$Plan->setIdCareer(1);
		$query = $this->PlanDAO_model->edit($Plan);

		redirect('Administrator_controller/Plans');
	}

	public function deletePlan()
	{
		// Borro los planes.
	}

	public function changeStatePlan()
	{

	}

	public function Blocks($id = null, $name = null)
	{
		/* Get the blocks from the database */
 		$query = $this->BlockDAO_model->show($id);
 		if ($name == null){
 			$data['actual'] = "Bloques";
 		}else{
 			$data['actual'] = urldecode($name);
 		}

		$data['listElement'] = $this->administrator_logic->getArrayBlocks($query);
		$data['iters'] = getBreadCrumbPlan();
		$data['ADD'] = getAddressBlocks();
		$data['STATE'] = stateMoveValid();

		$this->load->view("PlanPage/Header");
		$this->load->view("PlanPage/HomePlan", $data);
		$this->load->view("PlanPage/Footer", $data);
	}

	public function addBlock()
	{
		// Comunico a la bd.

	}

	public function editBlock($idBlock = null, $name = null)
	{
		// Edit the description of the block.
	}


	public function deleteBlock()
	{
		// Borro los planes.
	}

	public function changeStateBlock()
	{

	} 



	/****************************************
	- That function create the links for the 
	  professors
	****************************************/
	public function LoadGenerateLinksView()
	{
		// ************************************
		$idCareer = 1;
		// ************************************
		$data['profesors'] = $this->administrator_logic->findProfessors();
		$data['periods'] = $this->administrator_logic->findPeriods();
		
		if ($data['profesors'] == false)
		{
			echo "<script>alert('No hay profesores activos');</script>";
		}
		if ($data['periods'] == false)
		{
			echo "<script>alert('No hay periodos');</script>";
		}
		
		// Load the view
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/generarLinks", $data);
		$this->load->view("HomePage/Footer");
	}


	public function generateLinks()
	{
		// Get data from form 
		//*************************************
		$idCareer = 1;
		//*************************************
		$date = $this->input->post('date');
		$period = $this->input->post('period');
		$data = explode("-", $date);
		$data['profesors'] = $this->administrator_logic->findProfessors();
		$date = getdate();
		$sendDate = $data[0]."-".$data[1]."-".$data[2];

		// Check if the forms are registered or not
		if ($data['profesors'] != false)
		{
			foreach ($data['profesors']->result() as $p)
			{ 
				$result = $this->form_Logic->lookForSpecificForm($p->idProfessor, $period);
				// Create the form 
				if ($result == false) 
				{
					$result = $this->form_Logic->createForm($period, $sendDate, $p->idProfessor);
					if ($result == false) {
						echo "<script>alert('No se pudo crear el formulario');</script>";
					}
				}
			}
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