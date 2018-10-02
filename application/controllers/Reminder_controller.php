<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Reminder_controller extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->load->library('Reminder_Logic');
		$this->load->model('DAO/FormDAO_model');
		$this->load->model('DAO/ProfessorDAO_model');
		$this->load->model('DTO/FormDTO');
		$this->load->model('DTO/ProfessorDTO');
		$this->Reminder_Logic = new Reminder_Logic();
	}

	function index()
	{
		$forms = $this->getForms();
		foreach ($forms as $form) {
			$now = time();
			$formDate = strtotime($form['dueDate']);
			$dateDiff = round(($formDate-$now)/(60*60*24));
			if($dateDiff == $form['advanceDays'])
			{
				$email = $form['email'];
				$advanceDays = $form['advanceDays'];
				$this->sendEmail($email, $advanceDays);
			}
		}
	}

	function getForms()
	{
		return $this->Reminder_Logic->getForms();
	}

	function sendEmail($email, $advanceDays)
	{
		$from = 'Test@test.com';
		$fromComplement = 'Administración';
		$subject = 'Recordatorio Formulario';
		$message = 'Buenas'."\r\n"."\r\n".'Le recordamos que le quedan '.$advanceDays.'para llenar el formulario antes de que se venza.'."\r\n"."\r\n".'Saludos';

		$this->email->from($from, $fromComplement);
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}
}

?>