<?php
/******************************************************************************
	This helper has:

		- The BreadCrumb information.
			* Home
			* Home / Careers
			* Home / Careers / Plans
			* Home / Careers / Plans / Courses
			* Home / Professors

		- Address of all the pages in CRUD operations.
			* Get all elements
			* Change the state
			* Edit the information
			* Get only a instance
			* Add a new one

		- The state of valid operations. (Probably dropped in the future).
			* Valid (Insert, Drop, Get, Select) - No Valid (Move)
			* Valid (Get) - No Valid (Insert, Drop, Select, Move)
			* Valid (Insert, Drop, Get, Select, Move) - No valid ()

		- The confirmation of javascript operations in the modal.
			* validate Modal -> no need extra information.
			* validate Modal Array -> need extra information.
			
******************************************************************************/

function getBreadCrumbHome()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbProfessors()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Profesores",
			'HTML' => "Administrator_controller/Professors"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbCareer()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "Administrator_controller/Careers"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbPlan()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "Administrator_controller/Plans"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbBlock()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "Administrator_controller/Plans"
		),
		array (
			'NAME' => "Bloques",
			'HTML' => "Administrator_controller/Blocks"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbCourse()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Carreras",
			'HTML' => "Administrator_controller/Careers"
		),
		array (
			'NAME' => "Planes",
			'HTML' => "Administrator_controller/Plans"
		),
		array (
			'NAME' => "Bloques",
			'HTML' => "Administrator_controller/Blocks"
		),
		array (
			'NAME' => "Cursos",
			'HTML' => "Administrator_controller/Courses"
		)
	);
	return $breadCrumb;
}


function getBreadCrumbAssignCourses()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Period",
			'HTML' => "Administrator_controller/Period"
		)
	);
	return $breadCrumb;
}

function getAddressCareers()
{
	$address = array(
		'ADDRESS_1' => "Administrator_controller/Plans",
		'ADDRESS_2' => "Administrator_controller/changeStateCareer",
		'ADDRESS_3' => "Administrator_controller/getCareer/",
		'ADDRESS_4' => "Administrator_controller/deleteCareer/",
		'ADDRESS_5' => "Administrator_controller/addCareer"
	);
	return $address;
}

function getAddressPlans()
{
	$address = array(
		'ADDRESS_1' => "Administrator_controller/Blocks",
		'ADDRESS_2' => "Administrator_controller/changeStatePlan",
		'ADDRESS_3' => "Administrator_controller/getPlan/",
		'ADDRESS_4' => "Administrator_controller/deletePlan/",
		'ADDRESS_5' => "Administrator_controller/addPlan"
	);
	return $address;
}

function getAddressBlocks()
{
	$address = array(
		'ADDRESS_1' => "Administrator_controller/Courses",
		'ADDRESS_2' => "Administrator_controller/changeStateBlock",
		'ADDRESS_3' => "Administrator_controller/getBlock/",
		'ADDRESS_4' => "Administrator_controller/deleteBlock/",
		'ADDRESS_5' => "Administrator_controller/addBlock"
	);
	return $address;
}

function getAddressCourses()
{
	$address = array(
		'ADDRESS_1' => "Administrator_controller/Groups",
		'ADDRESS_2' => "Administrator_controller/changeStateCourse",
		'ADDRESS_3' => "Administrator_controller/getCourse/",
		'ADDRESS_4' => "Administrator_controller/deleteCourse/",
		'ADDRESS_5' => "Administrator_controller/addCourse"
	);
	return $address;
}


function getAddressProfessors()
{
	$address = array(
		'ADDRESS_1' => "Administrator_controller/Groups",
		'ADDRESS_2' => "Administrator_controller/changeStateProfessor",
		'ADDRESS_3' => "Administrator_controller/getProfessor/",
		'ADDRESS_4' => "Administrator_controller/deleteProfessor/",
		'ADDRESS_5' => "Administrator_controller/addProfessor"
	);
	return $address;
}

function getAddressPeriod()
{
	$address = array(
		'ADDRESS_3' => "index.php/Administrator_controller/getPeriod/",
		'ADDRESS_4' => "index.php/Administrator_controller/deletePeriod/",
		'ADDRESS_5' => "index.php/Administrator_controller/addPeriod"
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

function validateArrayModal($data)
{
	echo json_encode($data);
}

function printMessage($message)
{
    echo "<script>alert('".$message."')</script>";
}
?>