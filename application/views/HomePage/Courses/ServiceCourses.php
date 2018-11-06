<script>
var schedules = '';
var base_url = '<?= base_url() ?>';
</script>

<div id="allcontent">
    <div class="contInfo">

        <div class="selectBoxContainer">
            <span>Curso</span>
            <select class="form-control select" id="selectCourse" name='selectCourse'>
                <?php foreach($courses as $course){?>

                    <option value="<?= $course->name ?>" name="<?= $course->idBlock . "-" . $course->lessonNumber?>">
                        <?= $course->name;?>
                    </option> 
                <?php }?>
            </select>
        </div>

        <div class="selectBoxContainer">
            <span>Grupo</span>
            <select class="form-control select" id="selectGroup" name='selectGroup'>
                <?php foreach($groups as $group){?>
                    <option value="<?= $group->number ?>">
                        <?= $group->number;?>
                    </option> 
                <?php }?>
            </select>
        </div>
        
        <div class="bottonsService">
            <button class="btn btn-primary" onclick="createServiceCourse()">
                <i class="glyphicon glyphicon-plus"></i> 
                Agregar Curso Servicio
            </button>
        </div>
        <div class="bottonsService">
            <button type="button" id="btnSave" onclick="reselectPeriod()" class="btn btn-primary">
                Seleccionar Periodo
            </button>
        </div>
    </div>

    <script> var jArray = <?= json_encode($schedules) ?>; </script>
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