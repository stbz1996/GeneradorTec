<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller 
{
	private $idsOfMagistralClass = []; // Save the ids od information from assigment
	private $magistralClassList = [];

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');

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
		$this->load->model("Generator/PassInformation");

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


	// Creates a list of data from asigment courses (idprofesor, idgrupo, etc) 
	private function readDataFromView()
	{
		// Aviles
		$data = new PassInformation();
		$data->setAtributes(2, 5, 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new PassInformation();
		$data->setAtributes(2, 6, 1);
		$this->idsOfMagistralClass[] = $data;

		// carlos
		$data = new PassInformation();
		$data->setAtributes(3, 9 , 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new PassInformation();
		$data->setAtributes(3, 10, 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new PassInformation();
		$data->setAtributes(3, 11, 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new PassInformation();
		$data->setAtributes(3, 15, 1);
		$this->idsOfMagistralClass[] = $data;
		// chepe
		//$data = new PassInformation();
		$data->setAtributes(4, 4, 1);
		$this->idsOfMagistralClass[] = $data;


		foreach ($this->idsOfMagistralClass as $x) {
			echo $x->idProfessor.' - '.$x->idCourse.' - '.$x->idGroup.' @ ';
		}
	}










	/***********************************************
	This is the beginning of the Generator algorithm 
	***********************************************/
	public function index()
	{
		$this->readDataFromView(); // Esto se debe aliminar, solo carga datos de prueba 

		// - - Se cargan los profesores y toda su información
 		
		// - - Se deben cargar todos los horarios
		// Se debe bloquear los horarios que están inactivos en el sistema
			// 0: Bloqueado
			// 1: Seleccionado
			// 2: No seleccionado 
		
		// Se crean una lista de clases magistrales (profe, curso, grupo, periodo). La lista de clases magistrales son las que debemos acomodar 
		
		// Se crea la lista con los N bloques donde se van a colocar las clases magistrales(Es una matriz igual a la de horarios, pero esta va a guardar las clases magistrales)

		// Asignaciones de cursos obligatorios 
			// Se crea la lista de clases magistrales de los cursos obligatorios 
			// Se colocan los cursos obligatorios en la lista de los bloques 
			// Se deben bloquear los horarios de esos cursos obligatorios 
			// (Relación 1:1 entre la lista de horarios de un bloque y la lista de bloques donde están las clases magistrales ya asignadas)

		// Verificación de INTRO y TALLER
			// Se debe hacer la verificación de los cursos INTRO y TALLER, los cuales deben tener un mismo # de clases magistrales asignadas. 








		// ***************************************************************************
		// Generar los horarios  (AQUI ESTÁ LO DURO)
		/*
			Si la lista esta vacia
				- creo la solucion correcta 
				- me detengo: para que evalue ese mismo curso en otro hora a ver si hay más soluciones. 

			Dependiendo de las lecciones del curso, se seleccionan horas seguidas y se guardan en una lista temporal

			Verifico si el horario está disponible. 
				- Si: Meto el curso en la solucion
					- Elimino el horario de la lista de la solucion
					- Eliminar esas horas de la lista del profesor 
					- Elimino la clase de la solucion 
					- Llamo a generar de nuevo. 
				- No: Voy a buscar otro horario. 
					- se devuelve el horario al profesor 
				- Si no tengo opcion:	Me detengo.
					// Para que la clase anterior busque otro horario
		*/
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