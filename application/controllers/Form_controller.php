<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Form_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();

		$this->load->helper("form");
		$this->load->helper("url");

		$this->load->library('session');
		$this->load->library('Form_Logic');

		$this->load->model("DAO/FormDAO_model");
		$this->load->model("DTO/FormDTO");

		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DTO/ActivityDTO");

		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DTO/CourseDTO");

		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DTO/PlanDTO");

		$this->Form = new FormDTO();
		$this->Form_Logic = new Form_Logic();
	}


	function index()
	{
		//Get hashcode of link (p = value)
		$hashCode = $_GET['p'];
		
		//Get form by hashcode
		$queryForm = $this->Form_Logic->validateForm($hashCode);
		$newForm = $queryForm->row();
		
		//Setting Form
		$this->Form->setIdForm($newForm->idForm);
		$this->Form->setHashCode($hashCode);
		$this->Form->setState($newForm->state);
		$this->Form->setDueDate($newForm->dueDate);
		$this->Form->setIdProfessor($newForm->idProfessor);
		$this->Form->setIdPeriod($newForm->idPeriod);


		$this->session->set_userdata('hashCode', $hashCode);
		$this->session->set_userdata('idForm', $this->Form->getIdForm());
		$this->session->set_userdata('idProfessor', $this->Form->getIdProfessor());

		//Get initial information of professor
		$idProfessor = $this->Form->getIdProfessor();
		$idForm = $this->Form->getIdForm();

		$initialInformation = $this->showInitialInformation($idForm, $idProfessor)->row();

		//Assign information to show it in Form
		$data['dueDate'] = $this->Form->getDueDate();
		$data['professorFirstName'] = $initialInformation->professorName;
		$data['professorLastName'] = $initialInformation->lastName;
		$data['careerName'] = $initialInformation->careerName;
		$data['periodNumber'] = $initialInformation->number;
		$data['periodYear'] = $initialInformation->year;
		$data['formState'] = $this->Form->getState();
		$data['workload'] = $initialInformation->workLoad;

		//Get career id
		$idCareer = $initialInformation->idCareer;
		/*  USER STORY 4  */
		$plans = $this->showCareerPlans($idCareer);
		$coursesPlan = $this->showPlanCourses($plans);

		for ($i=0; $i < count($coursesPlan) ; $i++) { 
			if(!count($coursesPlan[$i]))
			{
				unset($plans[$i]);
				unset($coursesPlan[$i]);
			}
		}

		$data['plans'] = array_values($plans);
		$data['courses'] = array_values($coursesPlan);
		$data['activities'] = $this->getActivities($idForm);

		if(!$data['activities'])
		{
			$data['activities'] = array();
		}

		$coursesForm = $this->getFormCourses($idForm);
		$data['idCourses'] = array();
		$data['priorities'] = array();
		
		if($coursesForm)
		{
			foreach ($coursesForm as $course) {
				$data['idCourses'][] = $course['idCourse'];
				$data['priorities'][] = $course['priority'];
			}
		}

		/*END USER STORY 4*/

		$this->load->view("Forms/Header");
		$this->load->view("Forms/Content", $data);
		$this->load->view("Forms/Footer");
		
		//$cod = $_GET['p'];

		//echo "<script>alert('$cod');</script>";
	}


	/****************************************
	*Function that returns the initial in-	*
	*formation of the form 		 			*
	*										*
	*Input:									*
	*	-$idForm: Integer, id of form. 		*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor.								*
	*										*
	*Result: 								*
	*	Initial information to show it in 	*
	*	form.								*
	*****************************************/

	function showInitialInformation($idForm, $idProfessor)
	{
		return $this->Form_Logic->validateInformation($idForm, $idProfessor);
	}

	/****************************************
	*Function that get all values from view *
	*****************************************/
	function getDataFromView()
	{

		$idForm = $_SESSION['idForm'];
		$idProfessor = $_SESSION['idProfessor'];
		$workload = $this->input->post('workload_options');
		$activitiesDescription = $this->input->post('activityDescription');
		$activitiesWorkPorcent = $this->input->post('workPorcent');
		$idCourses = $this->input->post('idCourses');
		$flagEmptyActivity = 0;

		//Verify if professor assigned courses
		if(!$idCourses)
		{
			echo "<script>alert('No se puede guardar: No asignó cursos');</script>";
		}

		//Verify if courses assigned are less than workload
		else if(sizeof($idCourses) < $workload / 25)
		{
			echo "<script>alert('No se puede guardar: Cantidad de cursos es menor a la carga de trabajo asignado');</script>";
		}

		else
		{
			//Verify if professor add activities
			if($activitiesDescription)
			{
				//Get total porcent of activities
				$totalWorkPorcent = 0;
				foreach ($activitiesWorkPorcent as $workPorcent) {
					$totalWorkPorcent += $workPorcent;
				}

				//Verify if porcent of activities is less than workload
				if($workload >= $totalWorkPorcent)
				{
					//Verify if there's an activity without description
					if(in_array("", $activitiesDescription) || in_array(0, $activitiesWorkPorcent))
					{
						$flagEmptyActivity = 1;
					}
					else
					{
						$this->insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent);
					}
				}
				else
				{
					echo "<script>alert('No se puede guardar: Carga de trabajo es menor al porcentaje total de actividades');</script>";
				}
			}

			if(!$flagEmptyActivity)
			{
				$this->insertWorkload($idProfessor, $workload);

				$totalCourses = sizeof($idCourses);
				$priorities= $this->input->post('priorities');
				$courses = array();

				for ($i=0; $i < $totalCourses ; $i++) { 
					$courses[] = array(
						'idCourse' => $idCourses[$i],
						'idForm' => $idForm, 
						'priority' => $priorities[$i],
						'state' => 1
					);
				}
				$this->insertCoursesByForm($courses);
				echo "<script>
						alert('Datos se ingresaron correctamente');
					  </script>";
			}
			else
			{
				echo "<script>alert('No se puede guardar: Una o varias actividades no poseen datos correctos');</script>";
			}
		}
		$link = "Form_controller/?p=".$_SESSION['hashCode'];
		redirect($link, 'refresh');

		
	}

	/****************************************
	*Function that insert workload of a pro-*
	*fessor.			 		 			*
	*										*
	*Input:									*
	*	-$idProfessor: Integer, id of profe-*
	*	ssor. 								*
	*	-$workload: Integer, possible work-	*
	*	load assigned by the professor.		*
	*****************************************/
	function insertWorkload($idProfessor, $workload)
	{
		$this->Form_Logic->validateWorkload($idProfessor, $workload);
	}

	function insertActivities($idForm, $activitiesDescription, $activitiesWorkPorcent)
	{		
		$totalActivities = sizeof($activitiesDescription);

		for($i = 0; $i < $totalActivities; $i++)
		{	
			$activityDTO = new ActivityDTO();

			$activityDTO->setDescription($activitiesDescription[$i]);
			$activityDTO->setIdForm($idForm);
			$activityDTO->setWorkPorcent($activitiesWorkPorcent[$i]);

			$this->Form_Logic->validateInsertActivity($activityDTO);
		}		
	}

	function showPlanCourses($plans)
	{	
		$data = array();
		foreach ($plans as $plan) {
			$idPlan = $plan->getId();
			$courses = $this->Form_Logic->getPlanCourses($idPlan);
			$data[] = $courses;
		}

		return $data;
	}

	function showCareerPlans($idCareer)
	{
		return $this->Form_Logic->getCareerPlans($idCareer);
	}

	function insertCoursesByForm($courses)
	{
		$this->Form_Logic->insertCoursesForm($courses);
	}

	function getActivities($idForm)
	{
		return $this->Form_Logic->getActivities($idForm);
	}

	function getFormCourses($idForm)
	{
		return $this->Form_Logic->getFormCourses($idForm);
	}


}


?>