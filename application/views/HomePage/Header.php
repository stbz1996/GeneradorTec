<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
    // Here we can define the links to the controlles
    $link_to_generateLinks = base_url()."/Administration/GenerateLinks_controller/LoadGenerateLinksView";
    $linkToCourses = base_url()."/Administrator_controller/Courses";
    $linkToScheduleHours = base_url()."/Administrator_controller/showScheduleSelector";
    $linkToAdd = base_url()."/Administrator_controller/AddAdmin";
    $linkToCareers = base_url()."/Administrator_controller/Careers";
    $linkToProfessors = base_url()."/Administrator_controller/Professors";
    $linkToCurrentPeriod = base_url()."/Administrator_controller/Period";
    $linkToAssignCourses = base_url()."/Administrator_controller/AssignmentCourses";
    $linkToAssignAdvanceDays = base_url()."Administrator_controller/AdvanceDays";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
    <title>Generador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/jquery.mCustomScrollbar.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/custom.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/custom-themes.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/homePage.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/selectHours.css" />
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>img/favicon.png" />
</head>


<body onload="fillSchedulesStates()">
    <div class="page-wrapper chiller-theme toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div id="toggle-sidebar">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <br><br>

                <!-- sidebar-menu  -->
                <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Menú</span>
                        </li>
                        <li>
                            <a href="<?= $link_to_generateLinks ?>">
                                <i class="fa fa-calendar"></i>
                                <span>Generar Links</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToCareers ?>">
                                <i class="fa fa-folder"></i>
                                <span>Editar Información</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToScheduleHours ?>">
                                <i class="fa fa-book"></i>
                                <span>Horarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAdd ?>">
                                <i class="fa fa-address-book"></i>
                                <span>Agregar Administrador</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToProfessors?>">
                                <i class="fa fa-address-card"></i>
                                <span>Profesores</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToCurrentPeriod?>">
                                <i class="fa fa-address-card"></i>
                                <span>Periodo</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAssignCourses ?>">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Asignar Cursos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAssignAdvanceDays ?>">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Días de antelación</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
        </nav>
        
        <main class="page-content">
            <div class="container-fluid">
                <div class="row">

        <div class="sidebar-header" id="planHeader">
            <img class="img-responsive" id="image1" src="https://tecdigital.tec.ac.cr/servicios/capacitacion/guia_estudiantes/resources/images/tec.png">
        </div><br>