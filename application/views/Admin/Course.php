      <script>var base_url = '<?php echo base_url() ?>';</script>
      <div class="container">
        <h1>Cursos</h1>

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
                <td><?php echo $course->state;?></td>
                <td><?php echo $course->lessonNumber; ?></td>
                <td><?php echo $course->isCareer; ?></td>
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
                  <label class="control-label col-md-3">Estado</label>
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
                    <input name="inputCareer" placeholder="Carrera" class="form-control" type="text">
                  </div>
                </div>
              </div>

               <div class="form-group">
                  <label class="control-label col-md-3">Bloque</label>
                  <div class="col-md-9">
                    <select class="mdb-select colorful-select dropdown-primary" id="select" name='select'>
                        <option value="<?= $idParent ?>" selected><?= $actual ?></option>
                        <?php foreach($blocks as $block){?>
                          <? if ($idParent != $block->idBlock): ?>
                            <option value="<?= $block->idBlock?>"><?= $block->name ?></option>
                          <? endif; ?>
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

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->

  </main>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('css/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('css/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('css/datatables/js/dataTables.bootstrap.js')?>"></script>
  <script src="<?php echo base_url('js/modal.js')?>"></script>
  
  </body>
</html>
