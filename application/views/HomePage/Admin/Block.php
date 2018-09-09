<script>var base_url = '<?php echo base_url() ?>';</script>

<!-- Titles -->
<div>
    <h1>Bloques</h1>
    <p>Explicacion de lo que hay en la página</p>
</div>

<hr>

<!-- Content -->
<div>
    <div class="container">
        <button class="btn btn-primary" onclick="addBlock()"><i class="glyphicon glyphicon-plus"></i> Crear Bloque</button>
        <br/><br/>
        
        <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($blocks as $block){?>
              <tr>
                <td><?php echo "No code"; ?></td>
                <td><?php echo $block->name;?></td>
                <td>
                  <div class="btn-group" data-toggle="buttons">
                  <? if($block->state): ?>
                      <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                      <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off">
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                  <? else: ?>
                      <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" >
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                      <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                      </label>
                  <? endif; ?>
                  </div>
                </td>
                <td>
                  <button class="btn btn-primary" onclick='editBlock("<?=base_url($ADD['ADDRESS_3']) ?>",<?= $block->idBlock?>)'><i class="glyphicon glyphicon-pencil"></i></button>
                  <button class="btn btn-danger" onclick='deleteAll("<?=base_url().$ADD['ADDRESS_4']?>", <?php echo $block->idBlock;?>)'><i class="glyphicon glyphicon-remove"></i></button>
                  <button class="btn btn-success" onclick='location.href="<?=base_url().$ADD['ADDRESS_1']?>/<?= $block->idBlock ?>/<?= urlencode($block->name) ?>"' type="button"><i class="glyphicon glyphicon-chevron-right"></i></button>
                </td>
              </tr>
              <?php }?>
          </tbody>

          <tfoot>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Estado</th>
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
            <h3 class="modal-title">Crear Bloque</h3>
          </div>

          <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">
              <input type="hidden" value="0" name="inputIdBlock"/>

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

                <div class="form-group">
                  <label class="control-label col-md-3">Plan</label>
                  <div class="col-md-9">
                    <select class="mdb-select colorful-select dropdown-primary" id="select" name='select'>
                        <option value="<?= $idParent ?>" selected><?= $actual ?></option>
                        <?php foreach($plans as $plan){?>
                          <? if ($idParent != $plan->idPlan): ?>
                            <option value="<?= $plan->idPlan?>"><?= $plan->name ?></option>
                          <? endif; ?>
                        <?php }?>
                    </select>
                  </div>
                </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" id="btnSave" onclick='saveBlock()' class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<hr>

<!-- Los botones -->
<div class="modal-footer">
    Aqui los botones
</div>




      
      



  <!-- End Bootstrap modal -->
<!--
  </main>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script type="text/javascript" language="javascript" src="<?php echo base_url('css/datatables/js/jquery.dataTables.min.js')?>"></script>
      <script type="text/javascript" language="javascript" src="<?php echo base_url('css/datatables/js/dataTables.bootstrap.js')?>"></script>
      <script type="text/javascript" language="javascript" src="<?php echo base_url('js/modal.js')?>"></script>
  
  </div>

  </body>
</html>
-->