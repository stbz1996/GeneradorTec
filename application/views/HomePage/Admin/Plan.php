<script>var base_url = '<?php echo base_url() ?>';</script>

<!-- Los tituloso -->
<div>
    <h1 class="tittles">Planes</h1>
</div>

<hr>

<!-- Todo el contenido -->
<div id="allcontent">
  <button class="btn btn-primary" onclick="addPlan()">
      <i class="glyphicon glyphicon-plus"></i> 
      Crear Plan
  </button>

  <br><br>
        
  <table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th class="col-sm-7" id="textCenter">Nombre   </th>
          <th class="col-sm-1" id="textCenter">Estado   </th>
          <th class="col-sm-1" id="textCenter">Opciones </th>
        </tr>
      </thead>

      <tbody>
          <?php foreach($plans as $plan){?>
              <tr>
                  <td>
                      <div id="textInRowName">
                          <?php echo $plan->name;?>
                      </div>
                  </td>

                  <td id="textCenter">
                      <div class="btn-group" data-toggle="buttons">
                          <?php if($plan->state): ?>
                          <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $plan->idPlan ?>)'>
                            <input type="radio" name="radioActivate" id="option2" autocomplete="off" value="<?= $plan->idPlan ?>" checked>
                              <span class="glyphicon glyphicon-ok"></span>
                          </label>
                          <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $plan->idPlan ?>)'>
                            <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" value="<?= $plan->idPlan ?>">
                              <span class="glyphicon glyphicon-ok"></span>
                          </label>
                          <?php else: ?>
                          <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $plan->idPlan ?>)'>
                            <input type="radio" name="radioActivate" value="<?= $plan->idPlan ?>" id="option2" autocomplete="off" >
                              <span class="glyphicon glyphicon-ok"></span>
                          </label>
                          <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $plan->idPlan ?>)'>
                            <input type="radio" name="radioDesactivate" value="<?=$plan->idPlan?>" id="option2" autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok"></span>
                          </label>
                        <?php endif; ?>
                      </div>
                  </td>

                  <td id="textCenter">
                      <button class="btn btn-primary" onclick='editPlan("<?=base_url($ADD['ADDRESS_3']) ?>",<?= $plan->idPlan?>)'>
                          <i class="glyphicon glyphicon-pencil"></i>
                      </button>
                      <button class="btn btn-danger" onclick='deletePlan("<?=base_url().$ADD['ADDRESS_4']?>", <?php echo $plan->idPlan;?>)'>
                          <i class="glyphicon glyphicon-trash"></i>
                      </button>
                  </td>
              </tr>
          <?php }?>
      </tbody>
  </table>
  
  <div id="loader" style="left: 45%;"></div>

      


      
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
                  <input name="inputName" placeholder="Nombre" class="form-control" type="text"  >
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-9">
                  <input  name="inputState" placeholder="Estado" class="form-control" type="hidden">
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


</div>

<hr>



