<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
    // Here we can define the links to the controlles
    $link_to_generateLinks = base_url()."/Administration/GenerateLinks_controller/LoadGenerateLinksView";
    $linkToScheduleHours = base_url()."/Administration/Schedules_controller/showScheduleSelector";
    $linkToAdd = base_url()."/Administrator_controller/AddAdmin";
    $linkToPlans = base_url()."Administrator_controller/Plans";
    $linkToProfessors = base_url()."Administrator_controller/Professors";
    $linkToCurrentPeriod = base_url()."Administrator_controller/Period";
    $linkToAssignCourses = base_url()."Administrator_controller/AssignmentCourses";
    $linkToAssignAdvanceDays = base_url()."Administrator_controller/AdvanceDays";
    $linkToBlocks = base_url()."Administrator_controller/Blocks";
    $linkToCourses = base_url()."Administrator_controller/Courses";
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
    <link rel="stylesheet" href="<?=base_url()?>css/datatables/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/jquery.mCustomScrollbar.min.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/custom.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/custom-themes.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/homePage.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/selectHours.css" />
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/table.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/admin.css" />
    <link rel="stylesheet" href="<?=base_url()?>css/HomePage/GenerateLinks.css">
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>img/favicon.png" />
</head>


<body onload="fillSchedulesStates()" id="body">
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
                            <span>Administrar Información</span>
                        </li>
                        <li>
                            <a href="<?= $linkToPlans ?>">
                                <i class="fa fa-bookmark"></i>
                                <span>Planes</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToBlocks ?>">
                                <i class="fa fa-book"></i>
                                <span>Bloques</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToCourses ?>">
                                <i class="fa fa-clone"></i>
                                <span>Cursos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToCurrentPeriod?>">
                                <i class="fa fa-cube"></i>
                                <span>Periodos</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToScheduleHours ?>">
                                <i class="fa fa-calendar"></i>
                                <span>Horarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToProfessors?>">
                                <i class="fa fa-address-book"></i>
                                <span>Profesores</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAssignAdvanceDays ?>">
                                <i class="fa fa-hourglass-start"></i>
                                <span>Días de antelación</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAdd ?>">
                                <i class="fa fa-address-card"></i>
                                <span>Administradores</span>
                            </a>
                        </li>
                        <li class="header-menu">
                            <span>Generación de Horarios</span>
                        </li>
                        <li>
                            <a href="<?= $link_to_generateLinks ?>">
                                <i class="fa fa-link"></i>
                                <span>1. Generar Links</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $linkToAssignCourses ?>">
                                <i class="fa fa-columns"></i>
                                <span>2. Asignar Cursos</span>
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
        <br>