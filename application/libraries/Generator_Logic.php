<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generator_Logic{


	function __construct(){}

	public function getTotalActiveBlocks($idPlan)
	{
		$blockDAO = new BlockDAO_model();
		return $blockDAO->getTotalActiveBlocks($idPlan);
	}

	public function createClasses($data)
	{
		$classList = array();
		//print_r(count($data));
		//print_r($data);

		for($i = 0; $i < count($data); $i++)
		{
			$professor = $data[$i]['idProfessor'];
			$course = $data[$i]['idCourse'];
			$group = $data[$i]['idGroup'];
			$newClass = new AssignedCourse();
			$newClass->setAtributes($professor, $course, $group);
			array_push($classList, $newClass);
		}

		return $classList;
	}

}

?>