<?php
	
$this->load->library('email');

$this->email->from('jorgegr1707@gmail.com', 'Jorge González');
$this->email->to('jorgegr1707@gmail.com');

$this->email->subject('Email Test');
$this->email->message('Testing the email class.');

$this->email->send();

?>