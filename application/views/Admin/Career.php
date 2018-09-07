      <script>var base_url = '<?php echo base_url() ?>';</script>
      <div class="container">
        <h1 id="tituloPlanes" class="tituloNumero">Carreras</h1>
        
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($careers as $career){?>
              <tr>
                <td><?php echo "No code"; ?></td>
                <td><?php echo $career->name;?></td>
                <td>
                  <button class="btn btn-success" onclick='location.href="<?=base_url().$ADD['ADDRESS_1']?>/<?= $career->idCareer ?>/<?= urlencode($career->name) ?>"' type="button"><i class="glyphicon glyphicon-chevron-right"></i></button>
                </td>
              </tr>
            <?php }?>
          </tbody>

          <tfoot>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th></th>
            </tr>
          </tfoot>
        </table>

      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url('css/bootstrap/js/bootstrap.min.js')?>"></script>
      <script src="<?php echo base_url('css/datatables/js/jquery.dataTables.min.js')?>"></script>
      <script src="<?php echo base_url('css/datatables/js/dataTables.bootstrap.js')?>"></script>
      <script src="<?php echo base_url('js/modal.js')?>"></script>
      
  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Crear$career</h3>
          </div>

          <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
              <input type="hidden" value="0" name="inputIdCourse"/>

                <div class="form-group">
                  <label class="control-label col-md-3">Nombre</label>
                  <div class="col-md-9">
                    <input name="inputName" placeholder="Nombre" class="form-control" type="text">
                  </div>
                </div>

            </form>
          </div>

          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="saveCareer()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->

  </main>

  </body>
</html>
