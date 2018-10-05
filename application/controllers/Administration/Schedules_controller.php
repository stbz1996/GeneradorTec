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
		$this->load->library('System_Logic');
		$this->load->library('session');
		$this->load->helper("form");
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
		foreach ($schedules as $schedule)
		{
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
		$this->callView("Schedules/SchedulePage", $data);
	}


	/***********************************************************
	Load the information about the schedules in DB and show
	in the view the active an deactive schedules
	***********************************************************/
	public function saveScheduleInformation()
	{
		// All schedules on DB 
		$schedules = $this->administrator_logic->getAllSchedules();
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
}