<?php

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
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array ( 
			'NAME' => "Profesores",
			'HTML' => "Administrator_controller/Professors"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbPeriods()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Períodos",
			'HTML' => "Administrator_controller/Period"
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
			'NAME' => "Generar Links",
			'HTML' => "Administration/GenerateLinks_controller/LoadGenerateLinksView"
		),
		array (
			'NAME' => "Asignación de Cursos",
			'HTML' => "Administrator_controller/AssignmentCourses"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbSchedules()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Horarios",
			'HTML' => "Administration/Schedules_controller/showScheduleSelector"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbAdvance()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Días de antelación",
			'HTML' => "Administrator_controller/AdvanceDays"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbAdministrator()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Agregar Administrador",
			'HTML' => "Administrator_controller/AddAdmin"
		)
	);
	return $breadCrumb;
}

function getBreadCrumbGenerateLinks()
{
	$breadCrumb = array(
		array ( 
			'NAME' => "Inicio",
			'HTML' => "Administrator_controller"
		),
		array (
			'NAME' => "Generador de Links",
			'HTML' => "Administration/GenerateLinks_controller/LoadGenerateLinksView"
		)
	);
	return $breadCrumb;
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
		'ADDRESS_2' => "Administration/Courses_controller/changeStateCourse",
		'ADDRESS_3' => "Administration/Courses_controller/getCourse/",
		'ADDRESS_4' => "Administration/Courses_controller/deleteCourse/",
		'ADDRESS_5' => "Administration/Courses_controller/addCourse"
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

function printReal($message)
{
    echo "<script>console.log('".$message."')</script>";
}
?>