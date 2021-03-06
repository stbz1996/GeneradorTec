<script>var base_url = '<?php echo base_url() ?>';</script>

<!-- Titles -->
<div>
    <h1 class="tittles">Bloques</h1>
</div>

<hr>

<!-- Content -->
<div id="allcontent">
  <button class="btn btn-primary" onclick="addBlock()"><i class="glyphicon glyphicon-plus"></i> Crear Bloque</button>
  <br/><br/>
        
  <table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th class="col-sm-1" id="textCenter">Nombre   </th>
        <th class="col-sm-5" id="textCenter">Plan     </th>
        <th class="col-sm-1" id="textCenter">Estado   </th>
        <th class="col-sm-1" id="textCenter">Opciones </th>
      </tr>
    </thead>

    <tbody>
        <?php foreach($blocks as $block){?>
        <tr>
            <td>
                <div id="textInRowName">
                    <?php echo $block->name;?></td>
                </div>
            <td>
                <div id="textInRowName">
                    <?php echo $block->planName;?>
                </div>
            </td>
            <td id="textCenter">
                <div class="btn-group" data-toggle="buttons">
                    <?php if($block->state): ?>
                        <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                            <input type="radio" name="radioActivate" id="option2" autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok"></span>
                        </label>
                        <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                            <input type="radio" name="radioDesactivate" id="option2" autocomplete="off">
                            <span class="glyphicon glyphicon-ok"></span>
                        </label>
                    <?php else: ?>
                        <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                            <input type="radio" name="radioActivate" id="option2" autocomplete="off" >
                            <span class="glyphicon glyphicon-ok"></span>
                        </label>
                        <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $block->idBlock ?>)'>
                            <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" checked>
                            <span class="glyphicon glyphicon-ok"></span>
                        </label>
                    <?php endif; ?>
                </div>
            </td>
            
            <td id="textCenter">
                <button class="btn btn-primary" onclick='editBlock("<?=base_url($ADD['ADDRESS_3']) ?>",<?= $block->idBlock?>)'>
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
                <button class="btn btn-danger" onclick='deleteBlock("<?=base_url().$ADD['ADDRESS_4']?>", <?= $block->idBlock;?>)'><i class="glyphicon glyphicon-trash"></i>
                </button>
            </td>
        </tr>
        <?php }?>
    </tbody>
  </table>
</div>

<div id="loader" style="left: 45%"></div>    

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
              <select class="form-control" id="select" name='select'>

              <?php if ($idParent != null): ?>
                <option value="<?= $idParent ?>" selected><?= $actual ?></option>
              <?php endif; ?>

              <?php foreach($plans as $plan){?>
                <?php if ($idParent != $plan->idPlan): ?>
                  <option value="<?= $plan->idPlan?>"><?= $plan->name ?></option>
                <?php endif; ?>
              <?php }?>
              </select>
            </div>
          </div>
        </form>
      </div>


      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="saveBlock()" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<hr>