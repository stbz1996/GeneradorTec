<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reminder_Logic{

	function __construct()
	{}

	function getForms()
	{
		$formDAO = new FormDAO_model();
		$forms = $formDAO->showFormsReminder();
		return $forms;
	}

	
}