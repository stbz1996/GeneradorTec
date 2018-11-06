<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- Los titulos -->
<div>
    <h1 class="tittles">Periodos</h1>
</div>

<hr>

<!-- Todo el contenido -->
<div id="allcontent">
    <button class="btn btn-primary" onclick="addPeriod()">
        <i class="glyphicon glyphicon-plus"></i> 
        Agregar Periodo
    </button>
    <br/><br/>
        
    <table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="col-sm-8" id="textCenter">Periodo</th>
                <th class="col-sm-2" id="textCenter">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($periods as $period){?>
              <tr>
                <td>
                    <div id="textInRowName">
                        <?php echo $period->number, "\t - \t", $period->year;?>
                    </div>
                </td>
                
                <td id="textCenter">
                    <button class="btn btn-primary" onclick='editPeriod("<?=base_url($ADD['ADDRESS_3']) ?>", <?= $period->idPeriod ?>)'>
                        <i class="glyphicon glyphicon-pencil"></i> 
                    </button>
                    <button class="btn btn-danger" onclick='deletePeriod("<?=base_url().$ADD['ADDRESS_4']?>", <?= $period->idPeriod ?>)'>
                        <i class="glyphicon glyphicon-trash"></i> 
                    </button>
                </td>
              </tr>
              <?php }?>
        </tbody>
    </table>
    <div id="loader" style="left: 45%;"></div>
</div>



<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Agregar Periodo</h3>
        </div>

        <div class="modal-body form">
            <form action="#" id="form" class="form-horizontal">

                <input type="hidden" value="" name="inputIdPeriod"/>

                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Semestre</label>
                        <div class="col-md-9">
                            <select class="form-control" id="inputNumber" name='inputNumber'>
                                <option value="1" selected>I</option>
                                <option value="2">II</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Año</label>
                        <div class="col-md-9">
                            <select class="form-control" id="inputYear" name='inputYear'>
                                <option value="<?= date("Y"); ?>" selected><?= date("Y"); ?></option>
                                <option value="<?= date("Y")+1; ?>"><?= date("Y")+1; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" id="btnSave" onclick="savePeriod()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
         </div>
        </div>
      </div>
    </div>
</div>
<hr>