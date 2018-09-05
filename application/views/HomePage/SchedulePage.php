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
            <?= form_open("/Administrator_controller/xxxxxxxxxxxx") ?>
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
				for ($i=0; $i < 10; $i++) { ?>
					<div class="fileone">
						<div class="itemCol1"  > <?= $i ?> </div>
							<?php 
							$Did = 'D-'.$i.'-'.'0';  
							$Mid = 'M-'.$i.'-'.'0';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>

						<?php 
							$Did = 'D-'.$i.'-'.'1';  
							$Mid = 'M-'.$i.'-'.'1';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>

						<?php 
							$Did = 'D-'.$i.'-'.'2';  
							$Mid = 'M-'.$i.'-'.'2';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>

						<?php 
							$Did = 'D-'.$i.'-'.'3';  
							$Mid = 'M-'.$i.'-'.'3';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>
						<?php 
							$Did = 'D-'.$i.'-'.'4';  
							$Mid = 'M-'.$i.'-'.'4';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>

						<?php 
							$Did = 'D-'.$i.'-'.'5';  
							$Mid = 'M-'.$i.'-'.'5';
						?>
						<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
							<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
						</div>
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