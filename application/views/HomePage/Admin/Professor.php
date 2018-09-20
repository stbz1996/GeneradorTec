<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- Los titulos -->
<div>
    <h1>Profesores</h1>
    <p>Explicacion de lo que hay en la página</p>
</div>

<hr>

<!-- Todo el contenido -->
<div>
    <button class="btn btn-primary" onclick="addProfessor()"><i class="glyphicon glyphicon-plus"></i> Crear Profesor</button>
    <br/><br/>
        
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($professors as $professor){?>
            <tr>
                <td><?php echo $professor->lastName, "\t", $professor->name;?></td>
                <td>
                    <div class="btn-group" data-toggle="buttons">
                    <?php if($professor->state): ?>
                        <label class="btn btn-success active" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $professor->idProfessor ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                        </label>
                        <label class="btn btn-danger" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $professor->idProfessor ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off">
                        <span class="glyphicon glyphicon-ok"></span>
                        </label>
                    <?php else: ?>
                        <label class="btn btn-success" onclick='activateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $professor->idProfessor ?>)'>
                        <input type="radio" name="radioActivate" id="option2" autocomplete="off" >
                        <span class="glyphicon glyphicon-ok"></span>
                        </label>
                        <label class="btn btn-danger active" onclick='desactivateState("<?=base_url($ADD['ADDRESS_2']) ?>", <?= $professor->idProfessor ?>)'>
                        <input type="radio" name="radioDesactivate" id="option2" autocomplete="off" checked>
                        <span class="glyphicon glyphicon-ok"></span>
                        </label>
                    <?php endif; ?>
                    </div>
                </td>
                <td>
                    <button class="btn btn-primary" onclick='editProfessor("<?=base_url($ADD['ADDRESS_3']) ?>", <?= $professor->idProfessor ?>)'><i class="glyphicon glyphicon-pencil"></i></button>
                    <button class="btn btn-danger" onclick='deleteAll("<?=base_url().$ADD['ADDRESS_4']?>", <?= $professor->idProfessor ?>)'><i class="glyphicon glyphicon-remove"></i></button>
                </td>
            </tr>
            <?php }?>
        </tbody>

    </table>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Crear Profesor</h3>
            </div>

            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="inputIdProfessor"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nombre</label>
                            <div class="col-md-9">
                                <input name="inputName" placeholder="Nombre" class="form-control" type="text" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Apellidos</label>
                            <div class="col-md-9">
                                <input name="inputLastName" placeholder="Apellidos" class="form-control" type="text" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9">
                                <input name="inputState" placeholder="Activo" class="form-control" type="hidden">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Correo</label>
                            <div class="col-md-9">
                                <input name="inputEmail" placeholder="Correo" class="form-control" type="email" pattern=".+@+.com" maxlength="50" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="saveProfessor()" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
      </div>
    </div>
</div>
<hr>