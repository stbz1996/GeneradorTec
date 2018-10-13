    <div id="loader" style="left: 45%"></div>
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