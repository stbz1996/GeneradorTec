      <script>var base_url = '<?php echo base_url() ?>';</script>
      <div class="container">
        <h1 id="tituloPlanes" class="tituloNumero">Planes</h1>

        <button class="btn btn-primary" onclick="addPlan()"><i class="glyphicon glyphicon-plus"></i> Crear Plan</button>
        <br/><br/>
        
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Activo</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($plans as $plan){?>
              <tr>
                <td><?php echo "No code"; ?></td>
                <td><?php echo $plan->name;?></td>
                <td><?php echo $plan->state;?></td>
                <td>
                  <button class="btn btn-primary" onclick='editPlan("<?=base_url($ADD['ADDRESS_3']) ?>",<?= $plan->idPlan?>)'><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger" onclick='deleteAll("<?=base_url().$ADD['ADDRESS_4']?>", <?php echo $plan->idPlan;?>)'><i class="glyphicon glyphicon-remove"></i></button>
                  <button class="btn btn-success" onclick='location.href="<?=base_url().$ADD['ADDRESS_1']?>/<?= $plan->idPlan ?>/<?= urlencode($plan->name) ?>"' type="button"><i class="glyphicon glyphicon-chevron-right"></i></button>
                </td>
              </tr>
              <?php }?>
          </tbody>

          <tfoot>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Activo</th>
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
            <h3 class="modal-title">Crear Plan</h3>
          </div>

          <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
              <input type="hidden" value="0" name="inputIdPlan"/>

              <div class="form-group">
                <label class="control-label col-md-3">Nombre</label>
                <div class="col-md-9">
                  <input name="inputName" placeholder="Nombre" class="form-control" type="text">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-9">
                  <input name="inputState" placeholder="Estado" class="form-control" type="hidden">
                </div>
              </div>

            </form>
          </div>

          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="savePlan()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <!-- End Bootstrap modal -->
  </main>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url('css/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('css/datatables/js/jquery.dataTables.min.js')?>"></script>
  <script src="<?php echo base_url('css/datatables/js/dataTables.bootstrap.js')?>"></script>
  <script src="<?php echo base_url('js/modal.js')?>"></script>

  </body>
</html>
