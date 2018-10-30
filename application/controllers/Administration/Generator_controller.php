<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Generator_controller extends CI_Controller 
{
	// Variables
	private $idsOfMagistralClass   = []; // Save the ids od information from assigment
	private $magistralClassList    = []; // Save the list of magistral clases 
	private $professors            = []; // List of all professors
	private $semesterDisponibility = []; // The list of all the schedules
	private $assigmentList  = array(); // The list of the assigned magistral classes
	private $finalSolutions	= [];
	private $errorList      = array();
	private $limitOfresults = 100;
	private $generator_Logic;

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');

		// Clases
		$this->load->model("Generator/SemesterDisponibility");
		$this->load->model("Generator/FillInformation");
		$this->load->model("Generator/Activity");
		$this->load->model("Generator/Plan");
		$this->load->model("Generator/Group");
		$this->load->model("Generator/Solution");
		$this->load->model("Generator/Block");
		$this->load->model("Generator/Course");
		$this->load->model("Generator/Professor");
		$this->load->model("Generator/MagistralClass");
		$this->load->model("Generator/AssignedCourse");

		// DAO's
		$this->load->model("DAO/ActivityDAO_model");
		$this->load->model("DAO/ScheduleDAO_model");
		$this->load->model("DAO/PlanDAO_model");
		$this->load->model("DAO/GroupDAO_model");
		$this->load->model("DAO/BlockDAO_model");
		$this->load->model("DAO/CourseDAO_model");
		$this->load->model("DAO/ProfessorDAO_model");
		$this->load->model("DAO/FormDAO_model");

		$this->load->library('Generator_Logic');
		$this->generator_Logic = new Generator_Logic();
	}


	// Creates a list of data from asigment courses (idprofesor, idgrupo, etc) 
	private function readDataFromView($classes)
	{
		
		// If you receive the data by URL.
		/*
		for($i = 0; $i < count($classes); $i++)
		{
			$idProf = $classes[$i]->idProfessor;
			$idCourse = $classes[$i]->idCourse;
			$idGroup = $classes[$i]->idGroup;
			$data = new AssignedCourse();
			$data->setAtributes($idProf, $idCourse, $idGroup);
			$this->idsOfMagistralClass[] = $data;
		}
		*/
		
		
			
		// Adriana
		$data = new AssignedCourse();
		$data->setAtributes(1, 4, 1);
		$this->idsOfMagistralClass[] = $data;

		// Aviles
		$data = new AssignedCourse();
		$data->setAtributes(2, 5, 2);
		$this->idsOfMagistralClass[] = $data;

		// Carlos
		$data = new AssignedCourse();
		$data->setAtributes(3, 6, 3);
		$this->idsOfMagistralClass[] = $data;

		$data = new AssignedCourse();
		$data->setAtributes(3, 16, 1);
		$this->idsOfMagistralClass[] = $data;

		
	}


	function callView($viewName, $data)
	{
		$route = "HomePage/".$viewName;
		$this->load->view("HomePage/Header");
		$this->load->view($route, $data);
		$this->load->view("HomePage/Footer");
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


	/***************************************************************
	*Function that returns a list of filtered schedules with state *
	*1 in the semestresDisponibility                               *
	*Input:          							                   *
	*	-block: It is the numer of the block                       *
	*   -scheduleList: It is the list of schedules to filter       *
	*Output: 									                   *
	*	-Returns an array with filtered schedules                  *
	***************************************************************/
	private function filterSchedules($block, $scheduleList)
	{
		$validSchedules = array();
		foreach ($scheduleList as $numSchedule) 
		{
			$val = $this->semesterDisponibility->verifyScheduleState($block, $numSchedule);
			if ($val == 1) 
			{
				array_push($validSchedules, $numSchedule);
			}			
		}
		return $validSchedules;
	}


	/***************************************************************
	*Function that returns a list of schedules numbers             *
	*Input:          							                   *
	*   -scheduleList: It is the list of schedules to get numbers  *
	*Output: 									                   *
	*	-Returns an array with schedule numbers                    *
	***************************************************************/
	private function loadSchedulesNumbers($scheduleList)
	{
		$schedules = array(); 
		foreach ($scheduleList as $schedule) 
		{
			array_push($schedules, $schedule);
		}
		return $schedules;
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
		$numBlocks = $fillInformation->getNumBlocks($pIdPlan);

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


	/***************************************************************************
	*Function that returns a list of valid schedules for a magistral class     *
	*Input:          							                               *
	*	-pProfessorScheduleList: It is the array that we have to use to get    *
	*    the schedules                                                         *
	*Output: 									                               *
	*	-Returns an array with valid schedules for that magistral class        *
	***************************************************************************/
	public function getValidSchedules($pMagistralClass)
	{
		$professor = $pMagistralClass->getProfessor();
		$schedules = $this->loadSchedulesNumbers($professor->getSchedules()); 
		$course    = $pMagistralClass->getCourse();
		$lessons   = $course->getTotalLessons();
		$numBlock  = $course->getBlock()->getNumber();
		$filteredSchedules = $this->filterSchedules($numBlock, $schedules);
		$validSchedule = $this->generator_Logic->getValidSchedules($filteredSchedules, $lessons);
		return $validSchedule;
	}


	/***************************************************************************
	*Function that add an assignment list in the final solution. 			   *
	***************************************************************************/
	public function storeGeneratorResult()
	{
		// Clone the list of assigments
		$solution = new Solution();
		$data = array();
		foreach ($this->assigmentList as $assignClasses) {
			$data[] = clone $assignClasses;
		}
		$solution->setMagistralClassesList($data, clone $this->semesterDisponibility);
		$this->finalSolutions[] = $solution;
	}


	/***************************************************************************
	*Function that save a magistral class in assigment list and blocks the     * 
	*schedules in the semestres disponibility                                  *
	*Input:          							                               *
	*	-cm: It is the magistral class                                         *
	***************************************************************************/
	private function saveClassInAssigmentList($cm)
	{
		// Block the schedules in semester disponibility 
		$block = $cm->getCourse()->getBlock()->getNumber();
		foreach ($cm->getAssignedSchedules() as $schedule) 
		{
			$this->semesterDisponibility->desactivateSchedule($block, $schedule);
		}

		// Add the magistral class to the assigment list 
		array_push($this->assigmentList, clone $cm);
	}


	/***************************************************************************
	*Function that return to the semestres disponibility, the schedules of     * 
	*the magistral class.                                                      *
	*Input:          							                               *
	*	-block: It is the number of the block                                  *
	*	-list:  It is the list of schedules                                    *
	***************************************************************************/
	private function returnSchedulesToSemesterDisponibility($block, $list)
	{
		foreach ($list as $l) {
			$this->semesterDisponibility->activeSchedule($block, $l);
		}
	}


	/***************************************************************************
	*Function that assigned a magistral class and generate a solution          *
	*Input:          							                               *
	*	-cm:    It is the magistral class                                      *
	*	-index: It is the index of the magistral class                         *
	***************************************************************************/
	private function generator($cm, $index)
	{
		$filteredList = $this->getValidSchedules($cm);
		if (!count($filteredList)) 
		{
			$cm->addRejectedCount();
			return;
		}
		foreach ($filteredList as $schedule) 
		{
			// Save the temp schedule used for CM
			$tempSchedule = $schedule;

			// Delete the schedules of the professor
			$professorSchedules = $cm->getProfessor()->getSchedules();
			$finalListSchedules = $this->generator_Logic->deleteSchedulesToList($professorSchedules, $schedule);
			$cm->getProfessor()->setSchedules($finalListSchedules);

			// Assigned the CM to the assigmentList 
			$cm->setAssignedSchedules($schedule);
			$cm->addAvailableCount();
			$this->saveClassInAssigmentList($cm);
			if (count($this->magistralClassList) == ($index+1)) 
			{
				$this->storeGeneratorResult();
			}
			else{
				$newIndex = $index + 1;
				if ($newIndex < count($this->magistralClassList)) 
				{
					$this->generator($this->magistralClassList[$newIndex], $newIndex);
				}
				else{
					return;
				}
			}

			if (count($this->finalSolutions) == $this->limitOfresults) 
			{
				return;
			}

			// saca el curso de la lista y pone como habilitados los horarios del semestre
			$block = $cm->getCourse()->getBlock()->getNumber();	
			$this->returnSchedulesToSemesterDisponibility($block, $tempSchedule);
			array_pop($this->assigmentList);
			
			// le devuelvo los horarios el profesor 
			$list = $cm->getProfessor()->getSchedules();
			$returnedSchedules = $this->generator_Logic->addSchedulesToList($list, $tempSchedule);
			$cm->getProfessor()->setSchedules($returnedSchedules);
		}
	}


	/****************************************************************************
	* Function that fills a list with error about the magistral class assigment *
	****************************************************************************/
	private function findErrorsInAssigment($list)
	{
		foreach ($list as $cm) 
		{
			if ($cm->getCountOfAvailableSpaces() == 0) 
			{
				$error =  "Curso: ".$cm->getCourse()->getCode()." - ".$cm->getCourse()->getName().' - Grupo '.$cm->getGroup()->getNumber()."<br>";
				$error .= "Profesor: ".$cm->getProfessor()->getName()."<br>";
				$error .= "Error: NO pudo ser asignado, "; 
				if (count($cm->getProfessor()->getSchedules()) == 0) 
				{
					$error .= "el profesor no cuenta con horarios suficientes para la asignación de este curso.";
					$error .= "Solución: Habilite el formulario del profesor para que pueda agregar más horarios y luego continúe con la generación <br>";
				}
				else
				{
					$error .= "no se logró colocar en ninguna opción de horario válida <br>";
					$error .= "Solución: Asigne el curso a otro profesor para poder continuar<br>";
				}
				array_push($this->errorList, $error);
			}	
		}
	}


	/***********************************************
	This is the beginning of the Generator algorithm 
	***********************************************/
	public function index()
	{
		//Verify if code value exist
		if(isset($_GET['code']))
		{
			$classAssigned = $_GET['code'];
			$classes = json_decode(rawurldecode(base64_decode(rawurldecode($classAssigned))));
			$this->readDataFromView($classes); 
		}
		else{
			$this->readDataFromView(null); 
		}

		//print_r($this->idsOfMagistralClass);

		// Load the professors information 
		$this->fillProfessors($this->idsOfMagistralClass);
		// Load the magistral clases information 
		$this->fillMagistralClasses($this->idsOfMagistralClass);
		// Create the list of N blocks with the schedules of the actual plan
		$this->createSemesterDisponibility(1);

		// Asignaciones de cursos obligatorios 
			// Se crea la lista de clases magistrales de los cursos obligatorios 
			// Se colocan los cursos obligatorios en la lista de los bloques 
			// Se deben bloquear los horarios de esos cursos obligatorios 
			// (Relación 1:1 entre la lista de horarios de un bloque y la lista de bloques donde están las clases magistrales ya asignadas)

		// Verificación de INTRO y TALLER
			// Se debe hacer la verificación de los cursos INTRO y TALLER, los cuales deben tener un mismo # de clases magistrales asignadas. 

		// Call the generator algorithm 
		$cm = $this->magistralClassList[0];
		$this->generator($cm, 0);
		
		// #######################################
		// ### Check if there are no solutions ###
		// ###     Find the errors en list     ###
		// #######################################
		if (!count($this->finalSolutions)){
			$this->findErrorsInAssigment($this->magistralClassList);
		}



		foreach ($this->errorList as $error) 
		{
			echo '<br><br><br>'.$error;
		}

		
		$data['solutions'] = $this->finalSolutions;
		$this->callView('Generator/Generator', $data);
		
		//$this->printResultList(); // must be deleted
	}




	







	







	












































	private function printResultList()
	{
		echo "<br><br> SOLUCIONES <br><br><br><br>";
		$count = 1;
		foreach ($this->finalSolutions as $sol) {
			echo "Solucion: ".$count."<br>";
			$this->printSolution($sol->getMagistralClassesList());
			echo "### Puntage de la solución: ".$sol->getPoints().' ###';
			echo "<br><br><br><br>";
			$count = $count + 1;
		}
	}



	private function printSolution($sol){
		$points = 0;
		foreach ($sol as $x) 
		{
			echo 'Profesor: '.$x->getProfessor()->getName().'<br>';
			echo 'Curso: '.$x->getCourse()->getName().'<br>';
			echo 'Grupo: '.$x->getGroup()->getNumber().'<br>';
			echo 'Horarios: ';
			foreach ($x->getAssignedSchedules() as $y) 
			{
				echo $y.' - ';
			}
			echo '<br>';
			$points += $x->getEvaluation();
		}
		return $points;
	}



	public function printmatrix($m){
		foreach ($m as $x) {
			echo $x.' - ';
		}
	}



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
			echo '<br>';
		}
		echo '<br>';
	}
}