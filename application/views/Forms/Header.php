<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Formulario</title>
  <link rel="stylesheet" href="<?=base_url()?>css/Forms/reset.min.css">
  <link rel="stylesheet" href="<?=base_url()?>css/Forms/selectHours.css" />
  <link rel="stylesheet" href="<?=base_url()?>css/Forms/style.css">
  <link rel="stylesheet" href="<?=base_url()?>css/Forms/sweet-alert.css" />
</head>


<body onload="fillSchedulesStates()">