</div>
    <!-- page-wrapper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('js/modal.js')?>"></script>
    <script src="<?=base_url()?>js/HomePage/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?=base_url()?>js/HomePage/custom.js"></script>

    
	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h3 class="modal-title">Crear Curso</h3>
				</div>

				<div class="modal-body form">
					<form action="#" id="form" class="form-horizontal">
					<input type="hidden" value="<?= $VAR['idThis'] ?>" name="idThis"/>
					<input type="hidden" value="<?= $VAR['nameThis'] ?>" name="nameThis"/>
					<input type="hidden" value="<?= $VAR['idParent'] ?>" name="idParent"/>
					<input type="hidden" value="<?= $VAR['nameParent'] ?>" name="nameParent"/>

					<div class="form-body">

						<div class="form-group">
							<label class="control-label col-md-3">Nombre</label>
							<div class="col-md-9">
								<input name="inputName" placeholder="Nombre" class="form-control" type="text">
							</div>
						</div>

					</div>
				</form>
				</div>

				<div class="modal-footer">


					<button type="button" id="btnSave" onclick='save("<?php echo base_url().$ADD['ADDRESS_5']?>")' class="btn btn-primary">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>

			</div><!-- /.modal-content -->

		</div><!-- /.modal-dialog -->

	</div>