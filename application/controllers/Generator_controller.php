<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper("form");
		$this->load->helper("url");

		$this->load->library('session');

		$this->load->model('Generator/FillInformation');

		$this->load->model('Generator/Activity');
		$this->load->model('DAO/ActivityDAO_model');

		$this->load->model('Generator/Schedule');
		$this->load->model('DAO/ScheduleDAO_model');

		$this->load->model('Generator/Plan');
		$this->load->model('DAO/PlanDAO_model');

		$this->load->model('Generator/Group');
		$this->load->model('DAO/GroupDAO_model');

		$this->load->model('Generator/Block');
		$this->load->model('DAO/BlockDAO_model');

		$this->load->model('Generator/Course');
		$this->load->model('DAO/CourseDAO_model');

		$this->load->model('Generator/Professor');
		$this->load->model('DAO/ProfessorDAO_model');

		$this->load->model('DAO/FormDAO_model');

		$this->fillInformation = new FillInformation();

	}

	function index()
	{
		
	}
}

?>