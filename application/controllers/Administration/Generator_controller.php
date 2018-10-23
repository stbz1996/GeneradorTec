<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller 
{
	// Variables
	private $idsOfMagistralClass   = []; // Save the ids od information from assigment
	private $magistralClassList    = []; // Save the list of magistral clases 
	private $professors            = []; // List of all professors
	private $semesterDisponibility = []; // The list of all the schedules
	private $assigmentList         = []; // The list of the assigned magistral clases


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
		$this->load->model("Generator/MagistralClass");
		$this->load->model("Generator/assignedCarrerCourseOnView");

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
		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(2, 5, 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(2, 6, 2);
		$this->idsOfMagistralClass[] = $data;

		// carlos
		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(3, 9 , 1);
		$this->idsOfMagistralClass[] = $data;

		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(3, 10, 2);
		$this->idsOfMagistralClass[] = $data;

		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(3, 11, 3);
		$this->idsOfMagistralClass[] = $data;

		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(3, 15, 4);
		$this->idsOfMagistralClass[] = $data;
		
		// chepe
		$data = new assignedCarrerCourseOnView();
		$data->setAtributes(4, 4, 1);
		$this->idsOfMagistralClass[] = $data;		
	}


	/****************************************************
	*Function that fills the profesors list             *
	*Input: 									        *
	*	-$pList: It is the list of magistralClases id's *
	*Output: 									        *
	*	Fills the professors list                       *
	****************************************************/
	private function fillProfessors($pList)
	{
		$fillInformation = new FillInformation();
		foreach ($pList as $class) 
		{
			$professor = $fillInformation->fillProfessor($class->idProfessor);
			$this->professors[] = $professor;
		}
	}


	/*************************************************
	*Function that returns a profesor of the list of *
	*professors                                      *
	*Input: 									     *
	*	-$pId: It is the id of the professor (DB)    *
	*Output: 									     *
	*	Returns a professor instance                 *
	*************************************************/
	private function getProfessorInstanceById($pId)
	{
		foreach ($this->professors as $p) 
		{
			if ($p->getId() == $pId) {
				return $p;
			}
		}
	}


	/*************************************************
	*Function that fiils the list of magistralClases *
	*Input: 									     *
	*	-idsOfMagistralClass: List with the the      *
	*    information from view						 *
	*Output: 									     *
	*	Fills the magistralClassList   		         *
	*************************************************/
	private function fillMagistralClasses($pList)
	{
		$fillInformation = new FillInformation();
		foreach ($pList as $class) 
		{
			// Find the information 
			$professor = $this->getProfessorInstanceById($class->idProfessor);
			$course    = $fillInformation->fillCourse($class->idCourse);
			$group     = $fillInformation->fillGroup($class->idGroup);
			
			// Create the magistral class
			$magistralClass = new MagistralClass();
			$magistralClass->setProfessor($professor);
			$magistralClass->setCourse($course);
			$magistralClass->setGroup($group);
			$this->magistralClassList[] = $magistralClass;
		}
	}


	/********************************************************
	*Function that fiils the list of schedules, taking      * 
	*into account the blocked and the available             *
	*schedules in the system                                *
	*Input: 									            *
	*	-pIdPlan: It is the id of the actual plan           *
	*Output: 									            *
	*	Fills the schedules         		                *
	*   Use the next logic:                                 *
	*		Put 0: If the schedule is blocked by the carrer *
	*		Put 1: If is an available schedule              *
	*		Put 2: If is not an available schedule          *
	********************************************************/
	public function createSemesterDisponibility($pIdPlan)
	{
		$fillInformation = new FillInformation();
		// Find the blocks
		$blocks    = $fillInformation->getBlocks($pIdPlan);
		$numBlocks = count($blocks);
		// Find the schedules 
		$schedules    = $fillInformation->getSchedules();
		$numSchedules = count($schedules);
		// Create the complete schedule
		$this->semesterDisponibility = new SemesterDisponibility();
		$this->semesterDisponibility->fillInformation($numBlocks, $numSchedules);
		// Bloks the schedules that the carrer wants
		foreach ($schedules as $schedule) 
		{
			$index = $schedule->numberSchedule;
			$state = $schedule->state;
			for ($i = 1; $i <= $numBlocks; $i++) 
			{ 
				$this->semesterDisponibility->changeElementInMatrix($i, $index, $state);
			}	
		}
	}


	/********************************************************
	*Function that order a list                             *
	*Input: 									            *
	*	-array: It is the array to order                    *
	*Output: 									            *
	*	-Returns the array sorted                           *
	********************************************************/
	public function quick_sort($array)
	{
		$length = count($array);
		if($length <= 1)
		{
			return $array;
		}
		else
		{
			$pivot = $array[0];
			$left = $right = array();
			for($i = 1; $i < count($array); $i++)
			{
				if($array[$i] < $pivot)
				{
					$left[] = $array[$i];
				}
				else
				{
					$right[] = $array[$i];
				}
			}
			return array_merge(
						$this->quick_sort($left), 
						array($pivot), 
						$this->quick_sort($right)
					);
		}	
	}


	/********************************************************
	*Function that returns a list of valid tuples according *
	*with the schedules.                                    *
	*Input: 									            *
	*	-pProfessorScheduleList: It is the array that we    *
	*    have to use to get the tuples                      *
	*Output: 									            *
	*	-Returns an array with tuples                       *
	********************************************************/
	private function getTuplesOfSchedules($pProfessorScheduleList)
	{
		$list   = $this->quick_sort($pProfessorScheduleList);
		$result = array();
		$count  = count($list);
		for ($i=0; $i < $count; $i++) 
		{ 
			for ($j = ($i + 1); $j < $count; $j++) 
			{ 
				if (($list[$j] - $list[$i]) == 6) 
				{
					$tuple = array($list[$i], $list[$j]);
					array_push($result, $tuple);
					break;
				}
			}
		}
		return $result;
	}



	/***********************************************************
	*Function that returns a list of valid schedules according *
	*with the schedules of 2 and 2 not continuos lessons. For  *
	*example, two days or one day but in different hours, not  * 
	*continuos hours                                           *
	*Input: 									               *
	*	-pProfessorScheduleList: It is the array that we       *
	*    have to use to get the schedules                      *
	*Output: 									               *
	*	-Returns an array with valid schedules                 *
	***********************************************************/
	public function getValidSchedules1($pProfessorScheduleList)
	{
		$result = array();
		$validTuples = $this->getTuplesOfSchedules($pProfessorScheduleList);
	 	foreach ($validTuples as $tv1) 
	 	{
	 		foreach ($validTuples as $tv2) 
	 		{
	 			if ($tv1 != $tv2) 
	 			{
	 				$x = $this->quick_sort($tv1);
	 				$y = $this->quick_sort($tv2);
	 				if (($y[0]- $x[1]) == 6) 
	 				{
	 					$validSchedule = array($tv1[0], $tv1[1], $tv2[0], $tv2[1]);
	 					array_push($result, $validSchedule);
	 				}
	 			}
	 		}
	 	}
	 	return $result;
	}



// Pruebas 
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// Solo para ver resultados
	public function printTuples($list){
		foreach ($list as $l) {
			echo $l[0].' - '.$l[1].' --@@-- ';
		}
	}

	public function printTuples2($list){
		foreach ($list as $row) {
			foreach ($row as $val) 
			{
				echo $val.'-';
			}
			echo '  @@  ';
		}
	}





	/***********************************************
	This is the beginning of the Generator algorithm 
	***********************************************/
	public function index()
	{
		/*
		// Esto se debe aliminar, solo carga datos de prueba 
		$this->readDataFromView(); 
		// Load the professors information 
		$this->fillProfessors($this->idsOfMagistralClass);
		// Load the magistral clases information 
		$this->fillMagistralClasses($this->idsOfMagistralClass);
		// Create the list of N blocks with the schedules of the actual plan
		$this->createSemesterDisponibility(1);
		*/

		$unsorted = array(7,8,9,10,11,12,13,16,19,20,21,22,23,25,26,27,28,33, 34);
		$sorted = $this->quick_sort($unsorted);
		$x        = $this->getValidSchedules1($sorted);
		echo '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
		$this->printTuples2($x);








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
		$unsorted = array(1, 43,21,2,1,9,24,2,99,23,8,7,114,92,5);
		$sorted = $this->quick_sort($unsorted);
		print_r($sorted);



		$unsorted = array(7,8,9,10,11,12,13,19,20,21,23,25,26,27,33);
		$sorted   = $this->quick_sort($unsorted);
		$x        = $this->getTuplesOfSchedules($sorted);
		$this->printTuples($x);




		$unsorted = array(7,8,9,10,11,12,13,16,19,20,21,22,23,25,26,27,28,33, 34);
		$sorted = $this->quick_sort($unsorted);
		$x        = $this->getValidSchedules1($sorted);
		echo '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
		$this->printTuples2($x);
		*/