<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<?php
    // Here we can define the links to the controlles
    $link_to_generateLinks = base_url()."/index.php/Administrator_controller/LoadGenerateLinksView";
    $linkToCourses = base_url()."/index.php/Administrator_controller/Courses";
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
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>img/favicon.png" />
</head>

<body>
    <div class="page-wrapper chiller-theme toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                
                <div id="toggle-sidebar">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                
                <div class="sidebar-brand">
                    <a href="#">Generador de Horarios</a>
                </div>

                <div class="sidebar-header">
					<img class="img-responsive" src="https://www.tec.ac.cr/sites/default/files/media/branding/logo-tec.png">
                </div>

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
                            <a href="<?= $linkToCourses ?>">
                                <i class="fa fa-folder"></i>
                                <span>Cursos</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Columna #4</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar-menu  -->
            </div>
        </nav>
