<?php
	$button = array(
		'name' => 'sendData',
		'value' => 'Enviar Links',
		'class' => "btn btn-default"
	);
?>


<main class="page-content">
	<div class="container-fluid">
		<div class="row">
			
			<div class="titles">
              	<h1>Generación automática de links</h1>
              	<ul>
					<li type="disc"> Los profesores seleccionados recibirán el link de acceso al formuario respectivo.</li>
					<li type="disc"> Si un profesor es desmarcado, será desactivado.</li>
				</ul>
               	<p></p>
            </div>
            
            <hr>
            
            <!-- Shows the informatión of the profesors -->
            <div class="forms">
	            <?= form_open("/Administrator_controller/xxxxxx") ?>
				<form> 
					<div class="modal-body">
						<table>
							<?php 
								foreach ($profesors->result() as $p) { ?>
									<tr>
										<td><?= $p->idProfessor ?></td>
									    <td><?= $p->name." ".$p->lastName ?></td>
									    <td><?= $p->email ?></td>
									    <td><?= "Check" ?></td>
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
</main>