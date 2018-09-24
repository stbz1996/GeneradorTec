<!-- Los tituloso -->
<script>var base_url = '<?php echo base_url() ?>';</script>
<div>
    <h1>Asignación de Cursos</h1>
    <p>Prioridades  (Rojo - A), (Naranja - B), (Amarillo - C)</p>
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

				<div class="professorDiv" data-value="<?= $professor->idProfessor ?>" onclick="selectProfessor(this)">
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
			<hr>

			<?php 
       		foreach($courses as $course) { ?>

				<div class="coursesDiv" data-value="<?= $course->idCourse ?>" onclick="">
				 	<h4> <?= $course->name ?> </h4>
				 	<p> No ha sido asignado </p>
				 	<button class="btn btn-warning" onclick="selectCourse(this.parentElement)"><i class="glyphicon glyphicon-ok"></i></button>
				 	<input name="state" type="hidden" value="1" />
				 	<input name="reserved" type="hidden" value="0" />
				 	<p></p>
				</div>

			<?php  } ?>
		</div> 
	</section>
</div>


<!-- Los botones -->
<div class="modal-footer" id="divFooter">
    Aqui los botones
    <button type="button" id="btnSave" onclick="saveAssigned()" class="btn btn-primary">Guardar</button>
</div>

<div id="loader"></div>

