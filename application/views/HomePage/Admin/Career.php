<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- titles -->
<div>
    <h1>Carreras</h1>
    <p>Explicacion de lo que hay en la página</p>
</div>
<hr>

<!-- Content -->
<div>       
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($careers as $career) { ?>
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
        </div>
      </div>
    </div>
</div>

<hr>
