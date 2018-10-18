<?php

class assignedCarrerCourseOnView
{
	public $idProfessor;
    public $idCourse;
	public $idGroup;

	function __construct(){}

    function setAtributes($pProfessor, $pCourse, $pGroup)
    {
        $this->idProfessor = $pProfessor;
        $this->idCourse    = $pCourse;
        $this->idGroup     = $pGroup;
    }
}

?>