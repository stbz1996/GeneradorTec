

<?php
	$button = array(
		'name' => 'sendData',
		'value' => 'Enviar Links',
		'class' => "btn btn-default"
	);

	$buttonX = array(
		'name' => 'sendData',
		'value' => 'Generar Links X',
		'class' => "btn btn-info btn-lg",
		'data-toggle' => "modal", 
		'data-target' => "#myModal"
	);
?>

<div class="container">
	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
		Generar Links
    </button>
   

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
			
	<?= form_open("/HomaPage_controller/xxxxxx") ?>
	<form> 
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Se le enviará un link a los siguientes profesores </h4>
		</div>

		<div class="modal-body">
			<table>
				<?php 
					foreach ($profesors->result() as $p) { ?>
						<tr>
							<td><?= $p->idProfessor ?></td>
						    <td><?= $p->name." ".$p->lastName ?></td>
						</tr>
				<?php } ?>
			</table>
		</div>

		<div class="modal-footer">
			<?= form_submit($button) ?>
		</div>
	</form> 
	<?= form_close() ?>
			
</div>
</div>
</div>
</div>