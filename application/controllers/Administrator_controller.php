<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller {

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

	/****************************************
	- Get all careers. Show them.
	****************************************/
	public function Careers()
	{
		$array = getCareerSessions('0', "");
		$this->session->set_userdata($array);

		$data['iters'] = getBreadCrumbHome();
		$data['actual'] = "Careers";
		$data['ADD'] = getAddressCareers();
		$data['careers'] = $this->administrator_logic->getArrayCareers();

        $this->load->view('Admin/Header');
        $this->load->view('Admin/BreadCrumb', $data);
        $this->load->view('Admin/Career', $data);
	}

	/****************************************
	- Get all plans. Show the plans.
	****************************************/
	public function Plans($id = null, $name = null)
	{
		// if there is not a id, take the idCareer previous selected.
		if ($id == null)
		{
			$id = $this->session->userdata('idCareer');
			$name = $this->session->userdata('nameCareer');
		}else{
			$array = getCareerSessions($id, urldecode($name));
			$this->session->set_userdata($array);
		}

		/* These are data that the interface is going to get.*/
		$data['iters'] = getBreadCrumbCareer(); // Relative position
		$data['actual'] = urldecode($name);     // Actual position
		$data['ADD'] = getAddressPlans();       // Address of redirect.
		$data['plans'] = $this->administrator_logic->getArrayPlans($id);

        $this->load->view('Admin/Header');
        $this->load->view('Admin/BreadCrumb', $data);
        $this->load->view('Admin/Plan', $data);
	}

	/****************************************
	- Add a new plan
		The data is received by javascript.
	****************************************/
	public function addPlan()
	{
		$data = array(
			'name' => $this->input->post('inputName'),
			'state' => false,
			'idCareer' => $this->session->userdata('idCareer')
		);
		
		$result = $this->administrator_logic->insertPlan($data);
        validateModal();
	}

	/****************************************
	- Edit a new plan
		The data is received by javascript.
	****************************************/
	public function editPlan()
	{
		$data = array(
			'idPlan' => $this->input->post('inputIdPlan'),
			'name' => $this->input->post('inputName'),
			'state' => $this->input->post('inputState'),
			'idCareer' => $this->session->userdata('idCareer')
		);
		$result = $this->administrator_logic->editPlan($data);
		validateModal();
	}

	/****************************************
	- Get the information of a plan.
	****************************************/	
	public function getPlan($id)
    {
    	$data = $this->administrator_logic->getUniquePlan($id);
    	validateArrayModal($data);
    }

	/****************************************
	- Delete a plan (only if doesn't have any block reference).
	****************************************/
	public function deletePlan($id)
	{
		$data['id'] = $id;
		$result = $this->administrator_logic->deletePlan($data);
		validateModal();
	}

	/****************************************
	- Change the state of a plan.
	****************************************/
	public function changeStatePlan()
	{
		// Falta...
	}

	/****************************************
	- Get all blocks. Show the blocks.
	****************************************/
	public function Blocks($id = null, $name = null)
	{
		// if there is not a id, take the idCareer previous selected.
		if ($id == null)
		{
			$id = $this->session->userdata('idPlan');
			$name = $this->session->userdata('namePlan');
		}else{
			$array = getPlanSessions($this->session, $id, urldecode($name));
			$this->session->set_userdata($array);
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbPlan(); // Relative position
		$data['idParent'] = $id; // Id of the plan that the block belongs.
		$data['actual'] = urldecode($name);   // Actual position
		$data['ADD'] = getAddressBlocks();    // Get address of a block position
		$data['blocks'] = $this->administrator_logic->getArrayBlocks($id);

		// Take all the plans of the database.
		$data['plans'] = $this->administrator_logic->getArrayPlans(null);

        $this->load->view('Admin/Header');
        $this->load->view('Admin/BreadCrumb', $data);
        $this->load->view('Admin/Block', $data);
	}

	/****************************************
	- Add a new block. 
		The data is received by javascript.
	****************************************/
	public function addBlock()
	{
		$data = array(
			'name' => $this->input->post('inputName'),
			'state' => false,
			'idPlan' => $this->input->post('select')
		);
		$result = $this->administrator_logic->insertBlock($data);
        validateModal();

	}

	/****************************************
	- Edit the block.
		The data is received by javascript.
	****************************************/
	public function editBlock()
	{
		$data = array(
			'idBlock' => $this->input->post('inputIdBlock'),
			'name' => $this->input->post('inputName'),
			'state' => $this->input->post('inputState'),
			'idPlan' => $this->input->post('select')
		);
		$result = $this->administrator_logic->editBlock($data);
		validateModal();
	}

	/****************************************
	- Get the information of a block.
	****************************************/	
	public function getBlock($id)
    {
    	$data = $this->administrator_logic->getUniqueBlock($id);
    	validateArrayModal($data);
    }

    /****************************************
	- Delete a block (only if doesn't have any block reference).
	****************************************/
	public function deleteBlock($id)
	{
		$data['id'] = $id;
		$result = $this->administrator_logic->deleteBlock($data);
		validateModal();
	}

	/****************************************
	- Change the state of a block.
	****************************************/
	public function changeStateBlock()
	{
		// Falta...
	} 


	/****************************************
	- Get all courses. Show the view.
	****************************************/

    public function Courses()
    {
        $data['courses'] = $this->CourseDAO_model->getCourses();
        $data['URL'] = array('edit' => base_url('index.php/Administrator_controller/ajax_edit/'));
        $this->load->view('Admin/Header');
        $this->load->view('Admin/Course', $data);
    }

    public function addCourse()
    {
        $data = array(
            'code' => $this->input->post('inputCode'),
            'name' => $this->input->post('inputName'),
            'state' => $this->input->post('inputState'),
            'isCareer' => $this->input->post('inputCareer'),
            'lessonNumber' => $this->input->post('inputLessons'),
            'idBlock' => $this->input->post('inputBlock'),
        );

        $insert = $this->CourseDAO_model->addCourse($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($id)
    {
        $data = $this->CourseDAO_model->getCourse($id);
        echo json_encode($data);
    }


    public function updateCourse()
    {
        $data = array(
            'code' => $this->input->post('inputCode'),
            'name' => $this->input->post('inputName'),
            'state' => $this->input->post('inputState'),
            'isCareer' => $this->input->post('inputCareer'),
            'lessonNumber' => $this->input->post('inputLessons'),
            'idBlock' => $this->input->post('inputBlock'),
        );

        $this->CourseDAO_model->updateCourse(array('idCourse' => $this->input->post('inputIdCourse')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function deleteCourse($id)
    {
        $this->CourseDAO_model->deleteCourse($id);
        echo json_encode(array("status" => TRUE));
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
}

