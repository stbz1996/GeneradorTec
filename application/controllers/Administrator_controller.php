<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Administrator_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->library('System_Logic');
		$this->load->helper("functions_helper");

		$this->load->helper("form");
		$this->load->library('email');

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

        $this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/BreadCrumb', $data);
        $this->load->view('HomePage/Admin/Career', $data);
        $this->load->view('HomePage/Footer');
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

        $this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/BreadCrumb', $data);
        $this->load->view('HomePage/Admin/Plan', $data);
        $this->load->view("HomePage/Footer");
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

        $this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/BreadCrumb', $data);
        $this->load->view('HomePage/Admin/Block', $data);
        $this->load->view("HomePage/Footer");
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
    public function Courses($pId = null, $pName = null)
    {
    	// if there is not a id, take the idCareer, idPlan, and idBlock previous selected.
		if ($pId == null)
		{
			$pId = $this->session->userdata('idBlock');
			$pName = $this->session->userdata('nameBlock');
		}else{
			$array = getBlockSessions($this->session, $pId, urldecode($pName));
			$this->session->set_userdata($array);
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbBlock(); // Relative position
		$data['idParent'] = $pId; // Id of the plan that the block belongs.
		$data['actual'] = urldecode($pName);   // Actual position
		$data['ADD'] = getAddressCourses();    // Get address of a block position
		$data['courses'] = $this->administrator_logic->getArrayCourses($pId);

		// Take all the blocks of the database.
		$data['blocks'] = $this->administrator_logic->getArrayBlocks(null);
		
		$this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/BreadCrumb', $data);
        $this->load->view('HomePage/Admin/Course', $data);
        $this->load->view("HomePage/Footer");
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
	public function getCourse($pId)
    {
    	$data = $this->administrator_logic->getUniqueCourse($pId);
    	validateArrayModal($data);
    }


    /****************************************
	- Delete the course selected.
	****************************************/	
    public function deleteCourse($pId)
    {
    	$result = $this->administrator_logic->deleteCourse($pId);
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


	public function Professors($pId = null, $pName = null)
    {
    	// if there is not a id, take the idCareer, idPlan, and idBlock previous selected.
		if ($pId == null)
		{
			$pId = $this->session->userdata('idCareer');
			$pName = $this->session->userdata('nameCareer');
		}else{
			$array = getBlockSessions($this->session, $pId, urldecode($pName));
			$this->session->set_userdata($array);
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbProfessors(); // Relative position
		$data['idParent'] = $pId; // Id of the plan
		$data['actual'] = urldecode($pName);   // Actual position
		$data['ADD'] = getAddressProfessors();
		$data['professors'] = $this->administrator_logic->getArrayProfessors(); //id parametro

		$this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/BreadCrumb', $data);
        $this->load->view('HomePage/Admin/Professor', $data);
        $this->load->view("HomePage/Footer");
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
		validateModal();
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
		validateModal();
	}


 	/****************************************
	- Delete the selected professor.
	****************************************/	
    public function deleteProfessor($pId)
    {
    	$result = $this->administrator_logic->deleteProfessor($pId);
        validateModal();
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
	- That function create the links for the 
	  professors
	****************************************/
	public function LoadGenerateLinksView()
	{
		$idCareer = $_SESSION['idCareer'];
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		$data['periods']   = $this->administrator_logic->findPeriods(); 
		
		if ($data['profesors'] == true && $data['periods'] == true) {
			$this->callView("LinksPage", $data);
			$this->session->set_userdata('LinksState', "");
		}

		if ($data['profesors'] == false)
		{
			echo "<script>alert('No hay profesores activos');</script>";
			$this->index();
		}
		
		if ($data['periods'] == false)
		{
			echo "<script>alert('No hay periodos');</script>";
			$this->index();
		}
	}


	/***********************************************************
	Create hash of the forms to be sent to the professors
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
		$dateForEmail = $day."-".$month."-".$year;
		$period   = $this->input->post('period');
		
		// Find active professors
		$data['profesors'] = $this->administrator_logic->findProfessors($idCareer);
		
		// Check if the forms are registered or not
		if ($data['profesors'] != false)
		{
			foreach ($data['profesors']->result() as $p)
			{ 
				$isForRegistered = $this->form_Logic->lookForSpecificForm($p->idProfessor, $period);
				// If the form is not registered 
				if ($isForRegistered == false) 
				{
					$hashCode = $this->form_Logic->createForm($period, $sendDate, $p->idProfessor);
					// send the email if the form was created
					if ($hashCode != false) {
						$professorName = $p->name." ".$p->lastName;
						$email = $p->email;
						$hash = $hashCode;
						$this->sendMailToProfessor($professorName, $email, $hash, $dateForEmail);
					}
				}
			}
		}
		else{
			echo "<script>alert('No hay profesores activos');</script>";
		}

		// Call view
		$this->session->set_userdata('LinksState', "Los Links han sido enviados");
		$this->LoadGenerateLinksView();
	}


	/***********************************************************
	Send an email to the 
	***********************************************************/
	public function sendMailToProfessor($pProfessorName, $pEmail, $pHash, $pSendDate)
	{

		$administrator_Logic = new Administrator_Logic();

		$from = 'Test@test.com';
		$fromComplement = 'Administración';
		$subject = $administrator_Logic->getEmailsubject();
		$message = $administrator_Logic->getEmailMessage($pProfessorName, $pHash, $pSendDate);
		
		// Fill the email 
		$this->email->from($from, $fromComplement);
		$this->email->to($pEmail);
		$this->email->subject($subject);
		$this->email->message($message);


		//echo "<script>alert('$message');</script>";
		
		/*$res = $this->email->send();
		if ($res == false) 
		{	
			$error = "No se pudo enviar el correo a ".$pProfessorName;
			echo "<script>alert('$error');</script>";
		}
		*/
	}


	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function showScheduleSelector()
	{
		// The schedules are loaded
		$schedules = $this->administrator_logic->getAllSchedules();
		
		// Get the data for representation in viw 
		$system_Logic = new System_Logic();
		$hoursRepresentationForView = $system_Logic->getHoursRepresentationForView();
		$daysRepresentation = $system_Logic->getDaysRepresentation();
		$hoursRepresentation = $system_Logic->gethoursRepresentation();
	
		$scheduleCounter = 0;
		foreach ($schedules as $schedule) {
			$hour = $hoursRepresentation[$schedule['initialTime']]; 
			$day = $daysRepresentation[$schedule['dayName']];
			// To accord with the hour and the day, we sent information 
			$dataToView[$hour][$day]['id']    = $schedule['id'];
			$dataToView[$hour][$day]['state'] = $schedule['state']; 
			$scheduleCounter += 1;
		}
		// That varible is used to count the number of schedules in BD
		$this->session->set_userdata('scheduleCounter' , $scheduleCounter);
		$data['hours'] = $hoursRepresentationForView;
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
		$this->showScheduleSelector();
	}


	/****************************************
	- Add a new admin. Show the view.
	****************************************/
	public function AddAdmin()
	{
		$data['pageName'] = "Add a new admin";
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/Admin/addAdmin", $data);
		$this->load->view("HomePage/Footer");
	}


	/****************************************
	- Get the data of the new administrator and compare with the database.
	- If there's no admin with the username, add the new one.
	****************************************/
	public function getAdminData()
	{
		$state = false;
		$stateUsername = false;
		$username = $this->input->post('inputUsername');
		$password = $this->input->post('inputPassword');
		$autentification = $this->input->post('inputPasswordAgain');

		// Verify if the username, password and autentification fields were filled.
		$state = $this->administrator_logic->validAdminData($username, $password, $autentification);

		if (!$state)
		{
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}

		// Verify if the user is registered in the database.
		$stateUsername = $this->administrator_logic->isUserInDatabase($username);

		if (!$stateUsername)
		{
			redirect('Administrator_controller/addAdmin', 'refresh');
			return;
		}

		// Insert the new administrator.
		$this->administrator_logic->insertAdmin($username, $password);

		printMessage("Se ha agregado a la base de datos");
		redirect('Administrator_controller/index/');
	}

	/****************************************
	- Show the period settings
	****************************************/

	public function Period()
	{
		$data['ADD'] = getAddressPeriod();
		$data['periods'] = $this->administrator_logic->getArrayPeriods();

		$this->load->view('HomePage/Header');
        $this->load->view('HomePage/Admin/Period', $data);
        $this->load->view("HomePage/Footer");
	}

	/****************************************
	- Get the information of a professor.
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
        validateModal();
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
		validateModal();
	}


 	/****************************************
	- Delete the selected period.
	****************************************/	
    public function deletePeriod($pId)
    {
    	$result = $this->administrator_logic->deletePeriod($pId);
        validateModal();
	}
}