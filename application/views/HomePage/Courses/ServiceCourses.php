<script>var schedules = '';</script>
<script>var base_url = '<?php echo base_url() ?>';</script>

<div id="allcontent">
    <div class="service-courses-options">
        <div class="service-courses-option">
            <span>Curso</span>
            <select class="form-control" id="selectCourse" name='selectCourse'>
                <?php foreach($courses as $course){?>
                    <option value="<?php echo $course->name;?>" label="<?php echo $course->idBlock;?>">
                        <?php echo $course->name;?>
                    </option> 
                <?php }?>
            </select>
        </div>
        
        <div class="service-courses-option">
            <span>Numero de Lecciones</span>
            <select class="form-control" id="selectNumLessons" name='selectNumLessons'>
                <option value="2">2</option>
                <option value="3">3</option>
                <option selected value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <div class="service-courses-option">
            <span>Grupo</span>
            <select class="form-control" id="selectGroup" name='selectGroup'>
                <?php foreach($groups as $group){?>
                    <option value="<?php echo $group->number;?>">
                        <?php echo $group->number;?>
                    </option> 
                <?php }?>
            </select>
        </div>
        
        <div class="service-courses-option">
            <button class="btn btn-primary" onclick="createServiceCourse()">
                <i class="glyphicon glyphicon-plus"></i> 
                Agregar Curso Servicio
            </button>
        </div>
        <div class="service-courses-option">
            <button type="button" id="btnSave" onclick="reselectPeriod()" class="btn btn-primary">
                Seleccionar Periodo
            </button>
        </div>
    </div>
    
    <script> var jArray = <?php echo json_encode($schedules); ?>; </script>
    
    <div class="row courses" id="serviceCourses"></div>
 
    <br><br>
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