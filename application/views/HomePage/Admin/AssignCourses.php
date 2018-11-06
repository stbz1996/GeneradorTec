<!-- Los tituloso -->
<script>var base_url = '<?php echo base_url() ?>';</script>
<div>
    <h1 class="tittles">Asignación de Cursos</h1>
    <p>Prioridades: </p> 

    <div class="row">
    	<div class="control-label col-md-3">
		    <p>Rojo - Prioridad Máxima</p>
		    <span class="dotCircle redCircle"></span>
		</div>
		<div class="control-label col-md-3">
		    <p>Azul - Prioridad Media </p>
		    <span class="dotCircle blueCircle"></span>
		</div>
		<div class="control-label col-md-3">
	    	<p>Amarillo - Prioridad Mínima</p>
	    	<span class="dotCircle yellowCircle"></span>
	    </div>
    </div>
    
    <hr></hr>

    <div class="row">
	    <div class="control-label col-md-3">
			<button class="btn btn-primary" onclick="showModalPeriodForm()">Seleccionar Período</button>
		</div>
		<div class="control-label col-md-4">
		</div>
		<div id="buttonRightScreen">
		   	<button type="button" id="btnSave" onclick="saveAssigned()" class="btn btn-primary">Finalizar Asignación</button>
		</div>
	</div>
</div>

<hr>

<!-- Todo el contenido -->
<div class="container-fluid">
	<section id="sectionTwoScreens">

		<!-- Left section of the Screen. It contains the information about professors. -->
		<div id="leftScreen">
			<h3 id="titleSections">Profesores</h3>
			 <hr>
		</div> 

		<!-- Right section of the Screen. It contains the information about courses. -->
		<div id="rightScreen">
			<h3 id="titleSections">Cursos</h3>
			<hr>

			<?php 
       		foreach($courses as $course) { ?>

				<div class="coursesDiv" data-value="<?= $course->idCourse ?>">
				 	<h4> <?= $course->name ?> </h4>
				 	<div id="textGroup">
				 		<p>No ha sido asignado</p>
				 	</div>

				 	<div id="buttonPositioner">

				 		<div id="buttonLeftScreen">
						  	<div class="form-group">
			                  <label class="control-label col-md-3"></label>
			                  <div class="col-md-12">
				                  <select class="selectBox" id="selectGroup" name='selectValGroup'>
				                  <option>Grupos</option>
				                  <?php 
	       							foreach($groups as $group) { ?>
				                         <option value="<?= $group->idGroup ?>">
				                         	<?= $group->number ?>
				                         </option>
				                  <?php  } ?>
				                  </select>
			                  </div>
			              </div>
						</div> 

						<div id="buttonLeftNext">
							<button class="btn btn-success" onclick="selectCourse(this.parentElement.parentElement.parentElement)">Asignar</button>
						</div>
						<div style="clear:both"></div>

				 	</div>
				 	<input name="state" type="hidden" value="1" />
				 	<input name="reserved" type="hidden" value="0" />
				 	<p></p>
				</div>

			<?php  } ?>
		</div> 
	</section>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Elegir período</h3>
        </div>

        <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="inputIdPeriod"/>
                <div class="form-body">

                <div class="form-group">
                  <label class="control-label col-md-3">Período</label>
                  <div class="col-md-9">
                      <select class="form-control" id="selectPeriod" name='selectPeriod'>
                          <?php 
						    foreach($periods as $period) { ?>
						    	<option value="<?= $period->idPeriod ?>">
						    		Período <?= $period->year ?>-<?= $period->number ?> 
						    	</option>
						  <?php  } ?>
                      </select>
                  </div>
              	</div>
                    
              	</div>

            </form>
        </div>

        <div class="modal-footer">
            <button type="button" id="btnSave" onclick="choosePeriod()" class="btn btn-primary">Seleccionar</button>
         </div>
        </div>
      </div>
</div>

<div class="professorDiv" id="professorDiv" data-value="" onclick="selectProfessor(this)" style="display: none">
	<h4></h4>
	<p></p>
	<div class="progress">
		<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow=""
			aria-valuemin="0" aria-valuemax="" style="width:0%;">
			<p></p>
		</div>
	</div>
</div>

<div id="loader"></div>
