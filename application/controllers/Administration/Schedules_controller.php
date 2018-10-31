<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Schedules_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('Administrator_Logic');
		$this->load->model("DTO/ScheduleDTO");		
		$this->load->model("DAO/ScheduleDAO_model");
		$this->load->library('session');
		$this->load->helper("form");
		$this->load->helper("functions_helper");
	}	


	/****************************************
	Call and load a view 
	****************************************/
	function callView($viewName, $data)
	{
		$this->load->view("HomePage/Header");
		$this->load->view("HomePage/".$viewName, $data);
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

	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function showScheduleSelector()
	{
		// The schedules are loaded
		$schedules = $this->administrator_logic->getAllSchedules();
		foreach ($schedules as $schedule) {
 			$arr['id'] = $schedule->idSchedule;
 			$arr['state'] = $schedule->state;
 			$arr['description'] = $schedule->description;
 			$arr['numberSchedule'] = $schedule->numberSchedule;
  			$result[] = $arr;
 		}
		// That varible is used to count the number of schedules in BD
		$data['schedules'] = $result;
		$data['iters'] = getBreadCrumbSchedules(); // Relative position
		$data['actual'] = "Todos los horarios";
		$this->callViewBreadCrumb("Schedules/SchedulePage", $data);
	}


	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function saveScheduleInformation()
	{
		$schedule = new ScheduleDTO();
		for ($i = 1; $i < 85; $i++) 
		{ 
			$state = $this->input->post('Inp-'.$i);
			$schedule->setNumberSchedule($i);
			$schedule->setState($state);
			$this->administrator_logic->updateSchedule($schedule);
		}
		$this->showScheduleSelector();
	}
}