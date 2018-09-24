<!-- Titles -->
<div>
    <h1>Días de antelación</h1>
</div>

<hr>

<div>
	<p>Seleccione la cantidad de días para envíar recordatorios.</p>
	<select id="select-advanceDays">
		<?php 
		for($i = 1; $i <= 10; $i++){
		?>
		<option value="<?= $i?>"><?= $i?></option>
		<?php
		}?>
	</select>
	<button id="assignAdvanceDays" onclick='assignAdvanceDays("<?= base_url()?>/Administrator_controller/assignAdvanceDays")' value="Asignar">Asignar</button>
</div>