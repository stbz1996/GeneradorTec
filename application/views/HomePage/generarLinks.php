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
					<li type="disc"> Aquí se muestran los profesores activos a los que se les enviará en link para el periodo seleccionado.</li>
				</ul>
               	<p></p>
            </div>
            
            <hr>
            
            <!-- Shows the informatión of the profesors -->
            <div class="forms">
	            <?= form_open("/Administrator_controller/generateLinks") ?>
				<form>
					<div><input type="date" name="date" min="2018-03-25" max="2018-05-25"></div> 
					<div class="container">
					    <p>xxxxxxxx</p>
						<select class="form-control" name="period">
						<?php 
						foreach ($periods->result() as $p) { ?>
							<option value=<?= $p->idPeriod ?>> <?= $p->number.' - '.$p->year ?> </option>
						<?php } ?>
					    </select>
					</div>
					<div class="modal-body">
						<table class="profesorsTable">
							<tr>
								<td class="indicationsTable">ID</td>
							    <td class="indicationsTable">Profesor</td>
							    <td class="indicationsTable">Correo</td>
							    <td class="indicationsTable">Link</td>
							</tr>
							<?php 
								foreach ($profesors->result() as $p) { ?>
									<tr>
										<td class="numberTable"><?= $p->idProfessor ?></td>
									    <td class="profesorTable"><?= $p->name." ".$p->lastName ?></td>
									    <td class="emailTable"><?= $p->email ?></td>
									    <td class="linkTable"><?= "xxxxxxxxxxxxxxx" ?></td>
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