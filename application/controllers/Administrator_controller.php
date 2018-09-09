<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->library('logicControllerView/scheduleRelations');
		$this->load->helper("functions_helper");

		$this->load->helper("form");

		$this->load->library('Form_Logic');
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/AdministratorDAO_model");
		$this->load->model("DAO/CareerDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/PeriodDAO_model");
		$this->load->model("DAO/FormDAO_model");

		$this->load->model("DTO/ScheduleDTO");		
		$this->load->model("DAO/ScheduleDAO_model");

		$this->load->model("DTO/PeriodDTO");
		$this->load->model("DTO/ProfessorDTO");
		$this->load->model("DTO/FormDTO");
		$this->load->model("DTO/CareerDTO");
		$this->load->model("DTO/AdministratorDTO");
		$this->load->model("DTO/PlanDTO");

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
	That function is the first function that is called. 
	It is like a constructor. 
	***************************************************/
	function index()
	{
		$this->session->set_userdata('LinksState', " ");
		$this->callView("homePage", null);
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
		$data = array(
			'idBlock' => $this->input->post('id'),
			'state' => $this->input->post('state')
		);
		$this->administrator_logic->changeStateBlock($data);
		validateModal();
	}


	/****************************************
	- Get all courses. Show the view.
	****************************************/
    public function Courses($id = null, $name = null)
    {
    	// if there is not a id, take the idCareer, idPlan, and idBlock previous selected.
		if ($id == null)
		{
			$id = $this->session->userdata('idBlock');
			$name = $this->session->userdata('nameBlock');
		}else{
			$array = getBlockSessions($this->session, $id, urldecode($name));
			$this->session->set_userdata($array);
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbBlock(); // Relative position
		$data['idParent'] = $id; // Id of the plan that the block belongs.
		$data['actual'] = urldecode($name);   // Actual position
		$data['ADD'] = getAddressCourses();    // Get address of a block position
		$data['courses'] = $this->administrator_logic->getArrayCourses($id);

		// Take all the blocks of the database.
		$data['blocks'] = $this->administrator_logic->getArrayBlocks(null);

        $this->load->view('Admin/Header');
        $this->load->view('Admin/BreadCrumb', $data);
        $this->load->view('Admin/Course', $data);
    }

    /****************************************
	- Add a new course. 
		The data is received by javascript.
	****************************************/
    public function addCourse()
    {
        $data = array(
            'code' => $this->input->post('inputCode'),
            'name' => $this->input->post('inputName'),
            'state' => false,
            'isCareer' => $this->input->post('inputCareer'),
            'lessonNumber' => $this->input->post('inputLessons'),
            'idBlock' => $this->input->post('select'),
        );

        $insert = $this->administrator_logic->insertCourse($data);
        validateModal();
    }

    /****************************************
	- Edit the curse.
		The data is received by javascript.
	****************************************/
	public function editCourse()
	{
		$data = array(
			'idCourse' => $this->input->post('inputIdCourse'),
            'code' => $this->input->post('inputCode'),
            'name' => $this->input->post('inputName'),
            'state' => $this->input->post('inputState'),
            'isCareer' => $this->input->post('inputCareer'),
            'lessonNumber' => $this->input->post('inputLessons'),
            'idBlock' => $this->input->post('select'),
        );
		$result = $this->administrator_logic->editCourse($data);
		validateModal();
	}

	/****************************************
	- Get the information of a course.
	****************************************/	
	public function getCourse($id)
    {
    	$data = $this->administrator_logic->getUniqueCourse($id);
    	validateArrayModal($data);
    }


    /****************************************
	- Delete the course selected.
	****************************************/	
    public function deleteCourse($id)
    {
    	$result = $this->administrator_logic->deleteCourse($id);
        validateModal();
    }

    /****************************************
	- Change the state of a course.
	****************************************/
	public function changeStateCourse()
	{
		$data = array(
			'idCourse' => $this->input->post('id'),
			'state' => $this->input->post('state')
		);
		$this->administrator_logic->changeStateCourse($data);
		validateModal();
	}

	/****************************************
	- That function create the links for the 
	  professors
	****************************************/
	public function LoadGenerateLinksView()
	{
		$idCareer = $_SESSION['idCareer'];
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		$data['periods']   = $this->administrator_logic->findPeriods(); 
		if ($data['profesors'] == false)
		{
			echo "<script>alert('No hay profesores activos');</script>";
		}
		if ($data['periods'] == false)
		{
			echo "<script>alert('No hay periodos');</script>";
		}
		$this->callView("LinksPage", $data);
		$this->session->set_userdata('LinksState', "");
	}


	/***********************************************************
	Create the hash of the forms to be sent to the professors
	***********************************************************/
	public function generateLinks()
	{
		// Get data from form 
		$idCareer = $_SESSION['idCareer'];
		$date  = explode("-", $this->input->post('date'));
		$year  = $date[0];
		$month = $date[1];
		$day   = $date[2];
		$sendDate = $year."-".$month."-".$day;
		$period   = $this->input->post('period');
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		
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

		$this->session->set_userdata('LinksState', "Los Links han sido enviados");
		redirect("Administrator_controller/LoadGenerateLinksView");
	}


	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function showScheduleSelector()
	{
		// The schedules are loaded
		$schedules = $this->administrator_logic->getAllSchedules();

		$hoursRepresentationForView = array(1=>"7:30am - 8:20am", 2=>"8:30am - 9:20am", 3=>"9:30am - 10:20am", 4=>"10:30am - 11:20am", 5=>"1:00pm - 1:50pm", 6=>"2:00pm - 2:50pm", 7=>"3:00pm - 3:50pm", 8=>"4:00pm - 4:50pm", 9=>"4:50pm - 5:30pm", 10=>"5:30pm - 6:20pm", 11=>"6:20pm - 7:10pm", 12=>"7:25pm - 8:15pm", 13=>"8:15pm - 9:05pm", 14=>"9:05pm - 9:55pm"); 


		$relations = new scheduleRelations();

		$scheduleCounter = 0;
		foreach ($schedules as $schedule) {
			$hour = $relations->getHourRepresentation($schedule['initialTime']); 
			$day = $relations->getDayRepresentation($schedule['dayName']);
			// To accord with the hour and the day, we sent information 
			$dataToView[$hour][$day]['id']    = $schedule['id'];
			$dataToView[$hour][$day]['state'] = $schedule['state']; 
			$scheduleCounter += 1;
		}

		// That varible is used to count the number of schedules in BD
		$this->session->set_userdata('scheduleCounter' , $scheduleCounter);
		$data['hours'] = $relations->getHoursRepresentationForView();
		$data['days'] = $dataToView;
		$data['schedules'] = $schedules;
		$this->callView("SchedulePage", $data);
	}


	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function saveScheduleInformation()
	{
		// All schedules on DB 
		$schedules = $this->administrator_logic->getAllSchedules();
		
		////////////////////////////////////////////////////////////////////////////////
		// Use that Method if the schedules was not being deleted never, so, it 
		// takes the ids from 1 to n but in order, 1,2,3...,n. If the id x was deleted
		// the algoritm does not work well 
		$scheduleCounter = $_SESSION['scheduleCounter'];
		for ($i = 1; $i <= $scheduleCounter; $i++) { 
			$state = $this->input->post('Inp-'.$i);
			$schedule = new ScheduleDTO();
			$schedule->setIdSchedule($i);
			$schedule->setState($state);
			$this->administrator_logic->updateSchedule($schedule);
		}
		////////////////////////////////////////////////////////////////////////////////

		/*
		foreach ($schedules as $schedule) 
		{
			$idSchedule = $schedule['id'];
			$state = $this->input->post('Inp-'.$idSchedule);	
			// Create the object 
			$schedule = new ScheduleDTO();
			$schedule->setIdSchedule($idSchedule);
			$schedule->setState($state);
			$this->administrator_logic->updateSchedule($schedule);
		}
		*/
		$this->showScheduleSelector();
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
		$Admin = new AdministratorDTO();

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

