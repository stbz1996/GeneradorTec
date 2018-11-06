<?php
	$button = array(
		'name' => 'sendData',
		'value' => 'Guardar',
		'class' => 'btn btn-primary'
	);
?>

<div class="titles">
  	<h1 class="tittles">Horarios disponibles</h1>
    <ul>
		<li type="disc"> 
			Los espacios en verde serán los horarios que se habilitarán para ser seleccionados en el formulario de profesores. 
		</li>
	</ul>
</div>

<!-- Show the information about schedules -->
<?= form_open("/Administration/Schedules_controller/saveScheduleInformation") ?>
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
		$count = 0;
		$hours = array(
			'7:30am - 8:20am','8:30am - 9:20am','9:30am - 10:20am','10:30am - 11:20am',
			'11:30am - 12:20pm', '1:00pm - 1:50pm','2:00pm - 2:50pm','3:00pm - 3:50pm',
			'4:00pm - 4:50pm','4:50pm - 5:30pm','5:30pm - 6:20pm','6:20pm - 7:10pm',
			'7:25pm - 8:15pm','8:15pm - 9:05pm','9:05pm - 9:55pm'
		);
		for ($i = 0; $i < 14; $i++) { ?>
			<div class="fileone">
			<!-- It is the hour -->
			<div class="itemCol1"> <?= $hours[$i] ?> </div>
			<?php 
			for ($k=0; $k < 6; $k++) { ?>
				<!-- It is a normal space in schedule -->
				<?php 
					$baseId = $schedules[$count]['numberSchedule'];
					$baseState = $schedules[$count]['state'];
					$Did = 'Div-'.$baseId;
					$Mid = 'Inp-'.$baseId;
					$count += 1;
				?>
				<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
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