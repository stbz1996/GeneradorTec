<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- Los titulos -->
<div>
    <h1>Cursos</h1>
    <p>Explicacion de lo que hay en la página</p>
</div>

<hr>

<!-- Todo el contenido -->
<div>
    <button class="btn btn-primary" onclick="addCourse()"><i class="glyphicon glyphicon-plus"></i> Crear Curso</button>
    <br/><br/>
        
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Lecciones</th>
                <th>¿Carrera?</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($courses as $course){?>
              <tr>
                <td><?php echo $course->code;?></td>
                <td><?php echo $course->name;?></td>
                <td>
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
                <td><?php echo $course->lessonNumber; ?></td>
                <td>
                <?php if ($course->isCareer == 0): ?> 
                    No
                <?php else: ?>
                    Sí
                <?php endif; ?>
                </td>
                <td>
                  <button class="btn btn-primary" onclick='editCourse("<?=base_url($ADD['ADDRESS_3']) ?>", <?= $course->idCourse ?>)'><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger" onclick='deleteAll("<?=base_url().$ADD['ADDRESS_4']?>", <?= $course->idCourse ?>)'><i class="glyphicon glyphicon-remove"></i></button>
                </td>
              </tr>
              <?php }?>
        </tbody>

        <tfoot>
            <tr>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Lecciones</th>
                <th>¿Carrera?</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
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
                  <label class="control-label col-md-3">Bloque</label>
                  <div class="col-md-9">
                      <select class="mdb-select colorful-select dropdown-primary" id="select" name='select'>
                          <option value="<?= $idParent ?>" selected><?= $actual ?></option>
                          <?php foreach($blocks as $block){?>
                              <?php if ($idParent != $block->idBlock): ?>
                              <option value="<?= $block->idBlock?>"><?= $block->name ?></option>
                              <?php endif; ?>
                        <?php }?>
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