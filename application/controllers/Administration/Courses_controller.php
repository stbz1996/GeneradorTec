<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Courses_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('Administrator_Logic');
		$this->load->helper("functions_helper");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->administrator_logic = new Administrator_Logic();
	}

	public function loadCourses(){
		$data = $this->FindCourses();
		$this->callView("HomePage/Courses/CarrerCourses", $data);
	}


	/****************************************
	- Get all courses. Show the view.
	****************************************/
    public function FindCourses($pId = null, $pName = null)
    {
    	// Take all the plans from the database.
		$data['plans'] = $this->administrator_logic->getArrayPlans(null);

    	// if there is not a idPlan and idBlock previous selected.
		if ($pId == null)
		{
			$data['courses'] = $this->administrator_logic->getArrayCourses(null);
			$data['idParent'] = null;
			$data['actual'] = "Todos los cursos";
			// Obtenga el primer plan que se cargó la base de datos.
			$idPlan = $data['plans'][0]->idPlan;
			$namePlan = $data['plans'][0]->name; 
		}
		else
		{
			$data['courses'] = $this->administrator_logic->getArrayCourses($pId);
			$data['idParent'] = $pId; // Id of the plan that the block belongs.
			$data['actual'] = urldecode($pName);   // Actual position
			$plan = $this->administrator_logic->getPlanFromBlock($pId);
			$idPlan = $plan->idPlan;
			$namePlan = $plan->name;
		}

		/* These are data that the interface is going to need.*/
		$data['iters'] = getBreadCrumbBlock(); // Relative position
		$data['ADD'] = getAddressCourses();    // Get address of a block position
		$data['idParentPlan'] = $idPlan;
		$data['nameParentPlan'] = $namePlan;
		$data['blocks'] = $this->administrator_logic->getArrayBlocks($idPlan);
		return $data;
    }


    function callCarrerCourses(){
    	$data = $this->FindCourses();
    	$this->callView("HomePage/Courses/CarrerCourses", $data);
    }


    function callNoCarrerCourses(){
    	$data = $this->FindCourses();
    	$this->callView("HomePage/Courses/NoCarrerCourses", $data);
    }


    /********************************************************************** 
	This functions is equal to callView. But needs to load the breadCrumb.
	**********************************************************************/
	function callView($viewName, $data)
	{
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/Admin/BreadCrumb", $data);
		$this->load->view("HomePage/Courses/Buttons");
		$this->load->view($viewName, $data);
		$this->load->view("HomePage/Courses/Modals");
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
            'idBlock' => $this->input->post('selectBlock'),
        );

        $insert = $this->administrator_logic->insertCourse($data);
		return $insert;
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
            'idBlock' => $this->input->post('selectBlock'),
        );
		$result = $this->administrator_logic->editCourse($data);
		return $result;
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
        return $result;
    }




}