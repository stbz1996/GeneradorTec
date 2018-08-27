<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data["pageName"] = "Login";
		$this->load->view('Header', $data);

		$dato["string"] = "mensaje XXX ";
		$this->load->view('welcome_message', $dato);

		$this->load->view('Footer');
	}

}
