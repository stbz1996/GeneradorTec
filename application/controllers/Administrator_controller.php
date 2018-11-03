<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->helper("functions_helper");
		$this->load->helper("form");
		$this->load->library('Form_Logic');
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/AdministratorDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/PeriodDAO_model");
		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DAO/GroupDAO_model");
		$this->load->model("DTO/ScheduleDTO");		
		$this->load->model("DAO/ScheduleDAO_model");
		$this->load->model("DTO/PeriodDTO");
		$this->load->model("DTO/ProfessorDTO");
		$this->load->model("DTO/FormDTO");
		$this->load->model("DTO/AdministratorDTO");
		$this->load->model("DTO/PlanDTO");
		$this->load->model("DTO/GroupDTO_model");
		$this->load->model("DAO/CareerDAO_model");
		$this->administrator_logic = new Administrator_Logic();
		$this->form_Logic = new Form_Logic();
	}


	function callView($viewName, $data)
	{
		$route = "HomePage/".$viewName;
		$this->load->view("HomePage/Header");
		$this->load->view($route, $data);
		$this->load->view("HomePage/Footer");
	}

	/*************************************************** 
	This functions is equal to callView.. but needs to load the breadCrumb.
	***************************************************/
	function callViewBreadCrumb($viewName, $data)
	{
		$route = "HomePage/".$viewName;
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/BreadCrumb", $data);
		$this->load->view($route, $data);
		$this->load->view("HomePage/Footer");
	}


	/***************************************************
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		$this->session->set_userdata('LinksState', " ");
		$data['iters'] = getBreadCrumbHome(); // Relative position
		$data['actual'] = "Ventana Principal";
		$this->callViewBreadCrumb("homePage", $data);
	}

	/****************************************
	- Get all careers. Show all careers.
	****************************************/
	public function Careers()
	{
		$data['iters'] = getBreadCrumbHome();
		$data['actual'] = "Careers";
		$data['ADD'] = getAddressCareers();
		$data['careers'] = $this->administrator_logic->getArrayCareers();
		$this->callViewBreadCrumb("Admin/Career", $data);
	}

	/****************************************
	- Get all plans. Show the plans.
	****************************************/
	public function Plans()
	{
		$name = "Todos los planes";
		/* These are data that the interface is going to get.*/
		$data['iters'] = getBreadCrumbCareer(); // Relative position
		$data['actual'] = urldecode($name);     // Actual position
		$data['ADD'] = getAddressPlans();       // Address of redirect.
		$data['plans'] = $this->administrator_logic->getArrayPlans(null);

		$this->callViewBreadCrumb("Admin/Plan", $data);
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
			//'idCareer' => $this->session->userdata('idCareer') esta un NULL
			'idCareer' => 1
		);
		
		$result = $this->administrator_logic->insertPlan($data);
        return $result;
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
        return $result;
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
	public function deletePlan($pId)
	{
		$result = $this->administrator_logic->deletePlan($pId);
		return $result;
	}


	/****************************************
	- Change the state of a plan.
	****************************************/
	public function changeStatePlan()
	{
		$data = array(
			'idPlan' => $this->input->post('id'),
			'state' => $this->input->post('state')
		);
		$this->administrator_logic->changeStatePlan($data);
		validateModal();
	}

	/****************************************
	- Get all blocks. Show the blocks.
	****************************************/
	public function Blocks($id = null, $name = null)
	{
		// if there is not a id, take the idCareer previous selected.
		if ($id == null)
		{
			$data['blocks'] = $this->administrator_logic->getArrayBlocks(null);
			$data['idParent'] = null;
			$data['actual'] = "Todos los bloques";
		}
		else
		{
			$data['blocks'] = $this->administrator_logic->getArrayBlocks($id);
			$data['idParent'] = $id; // Id of the plan that the block belongs.
			$data['actual'] = urldecode($name);   // Actual position
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbPlan(); // Relative position
		$data['ADD'] = getAddressBlocks();    // Get address of a block position

		// Take all the plans of the database.
		$data['plans'] = $this->administrator_logic->getArrayPlans(null);

		$this->callViewBreadCrumb("Admin/Block", $data);
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
			'idPlan' => $this->input->post('select'),
			'number' => 0
		);
		$result = $this->administrator_logic->insertBlock($data);
        return $result;
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
		return $result;
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
	public function deleteBlock($pId)
	{
		$result = $this->administrator_logic->deleteBlock($pId);
		return $result;
	}


	/****************************************
	- Change the state of a block.
	****************************************/
	public function changeStateBlock()
	{
		$data = array(
			'idBlock' => $this->input->post('id'),
			'state' => $this->input->post('state')
		);
		$this->administrator_logic->changeStateBlock($data);
		validateModal();
	}


   

    /****************************************
	- Load all the blocks that belong a plan.
		The data is received by javascript.
	****************************************/
    public function loadBlocks($idPlan)
    {
    	$blocks = $this->administrator_logic->getArrayBlocks($idPlan);
    	validateArrayModal($blocks);
    }

 
	/****************************************
	- Get all the professors. Show the view.
	****************************************/
	public function Professors($pId = null, $pName = null)
    {
    	// if there is not an id, take the idCareer, idPlan, and idBlock previous selected.
		if ($pId == null)
		{
			$pId = $this->session->userdata('idCareer');
			$pName = $this->session->userdata('nameCareer');
		}
		else{
			$id = $this->session->userdata('idCareer');
			$name = $this->session->userdata('nameCareer');
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbProfessors(); // Relative position
		$data['idParent'] = $pId; // Id of the plan
		$data['actual'] = "Todos los profesores";   // Actual position
		$data['ADD'] = getAddressProfessors();
		$data['professors'] = $this->administrator_logic->getArrayProfessors(); //id parametro

		$this->callViewBreadCrumb("Admin/Professor", $data);
    }


	/****************************************
	- Add a new professor. 
		The data is received by javascript.
	****************************************/
	public function addProfessor()
	{
		$data = array(
			'name' => $this->input->post('inputName'),
			'lastName' => $this->input->post('inputLastName'),
			'email' => $this->input->post('inputEmail'),
			'idCareer' => 1 //debe actualizarse a id de carrera
		);

		$insert = $this->administrator_logic->insertProfessor($data);
		return $insert;
	}


	/****************************************
	- Get the information of a professor.
	****************************************/	
	public function getProfessor($pId)
    {
    	$data = $this->administrator_logic->getUniqueProfessor($pId);
    	validateArrayModal($data);
    }


	/****************************************
	- Edit the curse.
		The data is received by javascript.
	****************************************/
	public function editProfessor()
	{
		$data = array(
			'idProfessor' => $this->input->post('inputIdProfessor'),
            'name' => $this->input->post('inputName'),
            'lastName' => $this->input->post('inputLastName'),
            'email' => $this->input->post('inputEmail')
        );
		$result = $this->administrator_logic->editProfessor($data);
		return $result;
	}


 	/****************************************
	- Delete the selected professor.
	****************************************/	
    public function deleteProfessor($pId)
    {
    	$result = $this->administrator_logic->deleteProfessor($pId);
        return $result;
	}
	
	
	/****************************************
	- Change professor state.
	****************************************/
	public function changeStateProfessor()
	{
		$data = array(
			'idProfessor' => $this->input->post('id'),
			'state' => $this->input->post('state')
		);
		$this->administrator_logic->changeStateProfessor($data);
		validateModal();
	}


	/****************************************
	- Load the view to get the professor and courses
	****************************************/
	public function AssignmentCourses()
	{
		$data['iters'] = getBreadCrumbAssignCourses(); // Relative position
		$data['actual'] = "Asignación";
		$data['courses'] = $this->administrator_logic->getActiveCourses();
		$data['groups'] = $this->administrator_logic->getAllGroups();
		$data['periods'] = $this->administrator_logic->getArrayPeriods();

		$this->callViewBreadCrumb("Admin/AssignCourses", $data);
	}

	/****************************************
	- Load the professors selected by the actual period.
	****************************************/
	public function loadFormProfessor($idPeriod)
	{
		$professors = $this->administrator_logic->getProfessorWithForms($idPeriod);
		validateArrayModal($professors); // Send to Javascript the result of the operation.
	}

	/****************************************
	- Load the courses selected by the user.
	****************************************/
	public function loadSelectCourses($idProfessor, $idPeriod)
	{
		$result = $this->administrator_logic->loadSelectCourses($idProfessor, $idPeriod);
		validateArrayModal($result); // Send to Javascript the result of the operation.
	}

	/****************************************
	- Show the period´s view
	****************************************/
	public function Period()
	{
		$data['ADD'] = getAddressPeriod();
		$data['periods'] = $this->administrator_logic->getArrayPeriods();
		$data['iters'] = getBreadCrumbPeriods(); // Relative position
		$data['actual'] = "Todos los períodos";   // Actual position

        $this->callViewBreadCrumb("Admin/Period", $data);
	}

	/****************************************
	- Get the information of a period.
	****************************************/	
	public function getPeriod($pId)
    {
    	$data = $this->administrator_logic->getUniquePeriod($pId);
    	validateArrayModal($data);
    }
	
	
	/****************************************
	- Add a new period. 
	  The data is received by javascript.
	****************************************/
    public function addPeriod()
    {
        $data = array(
            'number' => $this->input->post('inputNumber'),
            'year' => $this->input->post('inputYear'),
        );

        $insert = $this->administrator_logic->insertPeriod($data);
		return $insert;
    }

	/****************************************
	- Edit the period.
	  The data is received by javascript.
	****************************************/
	public function editPeriod()
	{
		$data = array(
			'idPeriod' => $this->input->post('inputIdPeriod'),
            'number' => $this->input->post('inputNumber'),
            'year' => $this->input->post('inputYear')
        );
		$result = $this->administrator_logic->editPeriod($data);
		return $result;
	}


 	/****************************************
	- Delete the selected period.
	****************************************/	
    public function deletePeriod($pId)
    {
    	$result = $this->administrator_logic->deletePeriod($pId);
		return $result;
	}


	/****************************************
	- Add a new admin. Show the view.
	****************************************/
	public function AddAdmin()
	{
		$data['pageName'] = "Add a new admin";
		$data['iters'] = getBreadCrumbAdministrator(); // Relative position
		$data['actual'] = "Nuevo Admin";   // Actual position
		$this->callViewBreadCrumb("Admin/addAdmin", $data);
	}

	/*********************************************************************
	- Get the data of the new administrator and compare with the database.
	- If there's no admin with the username, add the new one.
	**********************************************************************/
	public function getAdminData()
	{
		$state = false;
		$stateUsername = false;
		$username = $this->input->post('inputUsername');
		$password = $this->input->post('inputPassword');
		$autentification = $this->input->post('inputPasswordAgain');
		$idCareer = 1;

		// Verify if the user is registered in the database.
		$stateUsername = $this->administrator_logic->isUserInDatabase($username);

		// If the user is not registered.
		if ($stateUsername)
		{
			// Insert the new administrator.
			$this->administrator_logic->insertAdmin($username, $password, $idCareer);
		}
	}

	public function AdvanceDays()
	{
		$data['iters'] = getBreadCrumbAdvance(); // Relative position
		$data['actual'] = "Días";   // Actual position
		$this->callViewBreadCrumb("Admin/AdvanceDays", $data);
	}

	public function assignAdvanceDays()
	{
		$advanceDays = $_POST['advanceDays'];
		$data = array('advanceDays'=>$advanceDays);
		$result = $this->administrator_logic->assignAdvanceDays($data);
		if($result)echo 1;
		else echo 0;
	}

}