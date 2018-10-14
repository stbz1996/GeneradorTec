<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		// Clases
		$this->load->model("Generator/SemesterDisponibility");
		$this->load->model("Generator/FillInformation");
		$this->load->model("Generator/Activity");
		$this->load->model("Generator/Schedule");
		$this->load->model("Generator/Plan");
		$this->load->model("Generator/Group");
		$this->load->model("Generator/Block");
		$this->load->model("Generator/Course");
		$this->load->model("Generator/Professor");

		// DAO's
		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DAO/ScheduleDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/GroupDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/FormDAO_model");
		
	}


	/***********************************************
	This is the beginning of the Generator algorithm 
	***********************************************/
	public function index()
	{
		// Se cargan los profesores y toda su información 
		
		// Se deben cargar todos los horarios 
		
		// Se debe bloquear los horarios que están inactivos en el sistema
		
		// Se crean una lista de clases magistrales (profe, curso, grupo, periodo). La lista de clases magistrales son las que debemos acomodar
		
		// Se crea la lista con los N bloques donde se van a colocar las clases magistrales(Es una matriz igual a la de horarios, pero esta va a guardar las clases magistrales)

		// Asignaciones de cursos obligatorios 
			// Se crea la lista de clases magistrales de los cursos obligatorios 
			// Se colocan los cursos obligatorios en la lista de los bloques 
			// Se deven verificar los choques
			// Se deben bloquear los horarios de esos cursos obligatorios 
			// (Relación 1:1 entre lalista de horarios de un bloque y la lista de bloques donde están las clases magistrales ya asignadas)

		// Verificación de INTRO y TALLER
			// Se debe hacer la verificación de los cursos INTRO y TALLER, los cuales deben tener un mismo # de clases magistrales asignadas. 

		// ***************************************************************************
		// Generar los horarios  (AQUI ESTÁ LO DURO)
			// Esta funcion recibe la clase magistral que se debe asignar 
			// Se toma un horario que no esté ocupado del profesor y se coloca la clase magistral ahi, en el bloque y hora correspondiente 
			// Se elimina el horario del bloque
			// se elimina el horario de la lista del profesor 
			// Si aun hay clases magistrales
				// Generar los horarios con la nueva clase magistral
			// si no
				// Se hace pop a la lista de asignaciones 
				// se devuelve el horario al profesor
		// ***************************************************************************
	}
}

		/*
		$fillInformation = new FillInformation();

		$x = $fillInformation->fillActivity(1);
		echo $x->getId().' ### ';
		echo $x->getDescription().' ### ';
		echo $x->getWorkPorcent().' ### ';

		$x = $fillInformation->fillPlan(1);
		echo $x->getId().' ### ';
		echo $x->getName().' ### ';

		$x = $fillInformation->fillGroup(1);
		echo $x->getId().' ### ';
		echo $x->getNumber().' ### ';

		$x = $fillInformation->fillBlock(1);
		echo $x->getId().' ### ';
		echo $x->getName().' ### ';
		echo 'Plan: '.$x->getPlan()->getName().' ### ';

		$x = $fillInformation->fillCourse(1);
		echo $x->getId().' ### ';
		echo $x->getName().' ### ';
		echo $x->getCode().' ### ';
		echo $x->getTotalLessons().' ### ';
		echo "Bloque: ".$x->getBlock()->getName().' ### ';
		echo "Plan: ".$x->getBlock()->getPlan()->getName();

		$x = $fillInformation->fillSchedule(85);
		echo $x->getId().' ### ';
		echo $x->getState().' ### ';
		echo $x->getNumSchedule().' ### ';
		echo $x->getDescription().' ### ';

		$x = $fillInformation->fillProfessor(4);
		echo 'ID: '.$x->getId().' ### ';
		echo $x->getWorkload().' ### ';
		echo $x->getName().' ### ';
		foreach ($x->getActivities() as $act) {
			echo "Activity: ".$act->getDescription().' - ';
		}
		foreach ($x->getCourses() as $cur) {
			echo "Course: ".$cur->getCode().' - ';
		}
		foreach ($x->getSchedules()  as $sch) {
			echo 'Schedule: '.$sch->getDescription().' - ';
		}

		*/