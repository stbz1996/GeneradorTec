<!-- Los tituloso -->
<div>
    <h1>Asignación de Cursos</h1>
</div>

<hr>

<!-- Todo el contenido -->
<div class="container-fluid">
	<section id="sectionTwoScreens">

		<!-- Left section of the Screen. It contains the information about professors. -->
		<div id="leftScreen">
			<h3 id="titleSections">Profesores</h3>
			 <hr>

			 <!-- Create a professor for every professor in the database. -->
			<?php 
       		foreach($professors as $professor) { ?>

				<div class="professorDiv" data-value="<?= $professor->idProfessor ?>">
				 	<h4> <?= $professor->name . " " . $professor->lastName ?> </h4>
				 	<p>Solicitó un <?= $professor->workLoad ?>% de carga</p>
				 	<div class="progress">
					  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $professor->workPorcent ?>"
					  aria-valuemin="0" aria-valuemax="<?= $professor->workLoad ?>" style="width:0%;">
					    <p>Trabajo de las personas</p>
					  </div>
					</div>
				</div>

			<?php  } ?>
		</div> 

		<!-- Right section of the Screen. It contains the information about courses. -->
		<div id="rightScreen">
			<h3 id="titleSections">Cursos</h3>
		</div> 
	</section>
</div>


<!-- Los botones -->
<div class="modal-footer">
    Aqui los botones
</div>