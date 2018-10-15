<script>var base_url = '<?php echo base_url() ?>';</script>
<!-- Los titulos -->
<div>
    <h1>Profesores</h1>
    <p>Explicacion de lo que hay en la página</p>
</div>

<hr>

<!-- Todo el contenido -->
<div id="allcontent">
    <button class="btn btn-primary" onclick="addProfessor()"><i class="glyphicon glyphicon-plus"></i> Crear Profesor</button>
    <br/><br/>
        
    <table id="table_id" class="table table-bordered table-hover table-condensed table-striped" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="col-sm-7" id="textCenter">Nombre</th>
                <th class="col-sm-1" id="textCenter">Estado</th>
                <th class="col-sm-2" id="textCenter">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($professors as $professor){?>
            <tr>
                <td id="textInRowName">
                    <?php echo $professor->lastName, "\t", $professor->name;?></td>
                <td id="textCenter">
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
                <td id="textCenter">
                    <button class="btn btn-primary" onclick='editProfessor("<?=base_url($ADD['ADDRESS_3']) ?>", <?= $professor->idProfessor ?>)'><i class="glyphicon glyphicon-pencil"></i> Editar</button>
                    <button class="btn btn-danger" onclick='deleteProfessor("<?=base_url().$ADD['ADDRESS_4']?>", <?= $professor->idProfessor ?>)'><i class="glyphicon glyphicon-trash"></i> Borrar</button>
                </td>
            </tr>
            <?php }?>
        </tbody>
        <div id="loader" style="left: 45%"></div>
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