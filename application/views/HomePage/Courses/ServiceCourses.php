<div id="allcontent">
    <div class="service-courses-options">
        <div class="class1">
        <span>Curso</span>
        <select class="form-control" id="selectCourse" name='selectCourse'>
            <?php foreach($courses as $course){?>
                <option selected value="<?php echo $course->name;?>">
                    <?php echo $course->name;?>
                </option> 
            <?php }?>
        </select>
        </div>
        
        <div class="class1">
        <span>Numero de Lecciones</span>
        <select class="form-control" id="selectCourse" name='selectCourse'>
            <option selected value="2">2</option>
            <option selected value="3">3</option>
            <option selected value="4">4</option>
        </select>
        </div>

        <div class="class1">
        <span>Grupo</span>
        <select class="form-control" id="selectGroup" name='selectGroup'>
            <?php foreach($groups as $group){?>
                <option selected value="<?php echo $group->number;?>">
                    <?php echo $group->number;?>
                </option> 
            <?php }?>
        </select>
        </div>

        <div class="class1">
        <span>Hora</span>
        <select class="form-control" id="selectSchedule" name='selectSchedule'>
            <?php $index = 0; $i=0; $days=['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']; ?>
            <?php foreach($schedules as $schedule){?>
                <option value="<?php echo $schedule->numberSchedule;?>">
                    <?php echo $days[$index].": ".$schedule->description;?>
                    <?php $i++; $index=($i%6); ?>
                </option> 
            <?php }?>
        </select>
        </div>
    </div>

    <button class="btn btn-primary" onclick="creatediv()">
        <i class="glyphicon glyphicon-plus"></i> 
        Agregar Curso Servicio
    </button>
    <button type="button" id="btnSave" onclick="reselectPeriod()" class="btn btn-primary">Seleccionar</button>
    <br><br>

    <div class="row" id="serviceCourses">
    </div>

</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modalPeriod" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Seleccionar Período</h3>
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
            <button type="button" id="btnSave" onclick="selectPeriod()" class="btn btn-primary">Seleccionar</button>
         </div>
        </div>
      </div>
</div>

<div id="loader"></div>