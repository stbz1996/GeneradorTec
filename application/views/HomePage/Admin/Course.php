<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- Los titulos -->
<div>
    <h1 class="tittles">Cursos</h1>
</div>

<hr>

<!-- Todo el contenido -->
<div id="allcontent">
    <button class="btn btn-primary" onclick="addCourse()"><i class="glyphicon glyphicon-plus"></i> Crear Curso</button>
    <br/><br/>
    



    <div>
      <label class="btn btn-success active" onclick=''>
          Cursos de carrera
      </label>
      <label class="btn btn-danger" onclick=''>
          Otros cursos
      </label>
    </div>


<!-- 

    <table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="col-sm-1" id="textCenter">Codigo</th>
                <th class="col-sm-1" id="textCenter">Nombre</th>
                <th class="col-sm-1" id="textCenter">Bloque</th>
                <th class="col-sm-1" id="textCenter">Plan</th>
                <th class="col-sm-1" id="textCenter">Estado</th>
                <th class="col-sm-1" id="textCenter">Lecciones</th>
                <th class="col-sm-1" id="textCenter">¿Carrera?</th>
                <th class="col-sm-1" id="textCenter">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($courses as $course){?>
              <tr>
                <td><?php echo $course->code;?></td>
                <td><?php echo $course->name;?></td>
                <td><?php echo $course->blockName;?></td>
                <td><?php echo $course->planName;?></td>
                <td id="textCenter">
                  <div class="btn-group" data-toggle="buttons">
                  <?php if($course->state): ?>
                      <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                      <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off">
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                  <?php else: ?>
                      <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" >
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                    
                      <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $course->idCourse ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                  <?php endif; ?>

                  </div>
                </td>
                <td id="textCenter"><?php echo $course->lessonNumber; ?></td>
                <td id="textCenter">
                <?php if ($course->isCareer == 0): ?> 
                    No
                <?php else: ?>
                    Sí
                <?php endif; ?>
                </td>
                <td id="textCenter">
                  <button class="btn btn-primary" onclick='editCourse("<?=base_url($ADD['ADDRESS_3']) ?>", <?= $course->idCourse ?>)'><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger" onclick='deleteCourse("<?=base_url().$ADD['ADDRESS_4']?>", <?= $course->idCourse ?>)'><i class="glyphicon glyphicon-trash"></i></button>
                </td>
              </tr>
              <?php }?>
        </tbody>
        <div id="loader" style="left: 45%"></div>
    </table>
-->
</div>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Crear Curso</h3>
        </div>

        <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="inputIdCourse"/>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Codigo</label>
                        <div class="col-md-9">
                            <input name="inputCode" placeholder="Codigo" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nombre</label>
                        <div class="col-md-9">
                            <input name="inputName" placeholder="Nombre" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9">
                            <input name="inputState" placeholder="Activo" class="form-control" type="hidden">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Lecciones</label>
                        <div class="col-md-9">
                            <input name="inputLessons" placeholder="Numero de Lecciones" class="form-control" type="text">
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label class="control-label col-md-3">¿Carrera?</label>
                        <div class="col-md-9">
                            <label class="radio-inline">
                              <input type="radio" value="1" name="inputCareer" checked>Sí
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="0" name="inputCareer">No
                            </label>
                        </div>
                    </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3">Plan</label>
                  <div class="col-md-9">
                      <select class="form-control" id="selectPlan" name='selectPlan'>
                          <?php if ($idParentPlan != null): ?>
                            <option value="<?= $idParentPlan ?>" selected><?= $nameParentPlan ?></option>
                          <?php endif; ?>
                        
                          <?php foreach($plans as $plan){?>
                              <?php if ($idParentPlan != $plan->idPlan): ?>
                                <option value="<?= $plan->idPlan?>"><?= $plan->name ?></option>
                              <?php endif; ?>
                          <?php }?>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <label class="control-label col-md-3">Bloque</label>
                  <div class="col-md-9">
                  <select class="form-control" id="selectBlock" name='selectBlock'>
                    <?php if ($idParentPlan != null): ?>
                        
                      <?php if ($idParent != null): ?>
                        <option value="<?= $idParent ?>" selected><?= $actual ?></option>
                      <?php endif; ?>

                      <?php foreach($blocks as $block){?>
                        <?php if ($idParent != $block->idBlock): ?>
                          <option value="<?= $block->idBlock?>"><?= $block->name ?></option>
                        <?php endif; ?>
                      <?php }?>
                    <?php endif; ?>
                  </select>
                  </div>
              </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" id="btnSave" onclick="saveCourse()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
         </div>
        </div>
      </div>
    </div>
</div>
<hr>