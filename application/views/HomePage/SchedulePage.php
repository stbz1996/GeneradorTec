<?php
	$button = array(
		'name' => 'sendData',
		'value' => 'Guardar',
		'class' => "btn btn-default"
	);
?>

<main class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="titles">
              	<h1>Horarios disponibles</h1>
               	<ul>
					<li type="disc"> 
						Los espacios en verde serán los horarios que se habilitarán para ser seleccionados en el formulario de profesores. 
					</li>
				</ul>
            </div>
            <!-- Show the information about schedules -->
            <?= form_open("/Administrator_controller/saveScheduleInformation") ?>
            <hr>
            <div>
				<div class="mainContainer">
					<div class="fileone">
						<div class="itemf1"> Hora </div>
						<div class="itemf1"> Lunes </div>
						<div class="itemf1"> Martes </div>
						<div class="itemf1"> Miercoles </div>
						<div class="itemf1"> Jueves </div>
						<div class="itemf1"> Viernes </div>
						<div class="itemf1"> Sabado </div>
					</div>

				<?php 
				for ($i=1; $i < 15; $i++) { ?>
					<div class="fileone">
						<!-- It is the hour -->
						<div class="itemCol1"> <?= $hours[$i] ?> </div>
						<?php 
						for ($k=1; $k < 7; $k++) { ?>
							<!-- It is a normal space in schedule -->
							<?php 
								$baseId = $days[$i][$k]['id'];
								$baseState = $days[$i][$k]['state'];
								$Did = 'Div-'.$baseId;
								$Mid = 'Inp-'.$baseId;
							?>
							<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item" onLoad="changeState('<?= $Mid ?>', '<?= $Did ?>')">
								<?= 'ID: '.$baseId.' State:'.$baseState ?>
								<input class="hiddenItem" id="<?= $Mid ?>" value="<?= $baseState ?>"type="hidden" name="<?= $Mid  ?>">
							</div>
						<?php } ?>						
					</div>
				<?php } ?>
				</div>
            </div>
            <hr>
            <div class="modal-footer">
				<?= form_submit($button) ?>
			</div>
			<?= form_close() ?>
		</div>
    </div>
</main>