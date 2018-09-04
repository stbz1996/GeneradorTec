<?php

function getBreadCrumbHome()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "index.php/Administrator_controller"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbCareer()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "index.php/Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "index.php/Administrator_controller/Careers"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbPlan()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "index.php/Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "index.php/Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "index.php/Administrator_controller/Plans"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbBlock()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "index.php/Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "index.php/Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "index.php/Administrator_controller/Plans"
		),
		array (
			'NAME' => "Bloques",
			'HTML' => "index.php/Administrator_controller/Blocks"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbCourse()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "index.php/Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "index.php/Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "index.php/Administrator_controller/Plans"
		),
		array (
			'NAME' => "Bloques",
			'HTML' => "index.php/Administrator_controller/Blocks"
		),
		array (
			'NAME' => "Cursos",
			'HTML' => "index.php/Administrator_controller/Courses"
		)
	);
	return $breadCrumb;
}

function getAddressCareers()
{
	$address = array(
		'ADDRESS_1' => "index.php/Administrator_controller/Plans",
		'ADDRESS_2' => "index.php/Administrator_controller/changeStateCareer",
		'ADDRESS_3' => "index.php/Administrator_controller/editCareer",
		'ADDRESS_4' => "index.php/Administrator_controller/deleteCareer",
		'ADDRESS_5' => "index.php/Administrator_controller/addCareer"
	);
	return $address;
}

function getAddressPlans()
{
	$address = array(
		'ADDRESS_1' => "index.php/Administrator_controller/Blocks",
		'ADDRESS_2' => "index.php/Administrator_controller/changeStatePlan",
		'ADDRESS_3' => "index.php/Administrator_controller/editPlan",
		'ADDRESS_4' => "index.php/Administrator_controller/deletePlan",
		'ADDRESS_5' => "index.php/Administrator_controller/addPlan"
	);
	return $address;
}

function getAddressBlocks()
{
	$address = array(
		'ADDRESS_1' => "index.php/Administrator_controller/Courses",
		'ADDRESS_2' => "index.php/Administrator_controller/changeStateBlock",
		'ADDRESS_3' => "index.php/Administrator_controller/editBlock",
		'ADDRESS_4' => "index.php/Administrator_controller/deleteBlock",
		'ADDRESS_5' => "index.php/Administrator_controller/addBlock"
	);
	return $address;
}

function getAddressCourses()
{
	$address = array(
		'ADDRESS_1' => "index.php/Administrator_controller/Groups",
		'ADDRESS_2' => "index.php/Administrator_controller/changeStateCourse",
		'ADDRESS_3' => "index.php/Administrator_controller/editCourse",
		'ADDRESS_4' => "index.php/Administrator_controller/deleteCourse",
		'ADDRESS_5' => "index.php/Administrator_controller/addCourse"
	);
	return $address;
}

function stateValid()
{
	$state = array(
		'STATE_ADD' => 'VALID',
		'STATE_EDIT' => 'VALID',
		'STATE_DELETE' => 'VALID',
		'STATE_CHANGE' => 'VALID',
		'STATE_MOVE' => 'NO_VALID',
		'STATE_GET' => 'VALID'
	);
	return $state;
}


function stateNoValid()
{
	$state = array(
		'STATE_ADD' => 'NO_VALID',
		'STATE_EDIT' => 'NO_VALID',
		'STATE_DELETE' => 'NO_VALID',
		'STATE_CHANGE' => 'NO_VALID',
		'STATE_MOVE' => 'NO_VALID',
		'STATE_GET' => 'VALID'
	);
	return $state;
}

function stateMoveValid()
{
	$state = array(
		'STATE_ADD' => 'VALID',
		'STATE_EDIT' => 'VALID',
		'STATE_DELETE' => 'VALID',
		'STATE_CHANGE' => 'VALID',
		'STATE_MOVE' => 'VALID',
		'STATE_GET' => 'VALID'
	);
	return $state;
}

function validateModal()
{
	echo json_encode(array("status" => TRUE));
}

?>