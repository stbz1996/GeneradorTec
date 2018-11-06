<!-- Titles -->
<div>
    <h1 class="tittles">Días de antelación</h1>
</div>

<hr>

<div id="allcontent">
	<p>Se enviará un recordarotio N días antes de la fecha de vencimiento</p>
	<select id="select-advanceDays" class="advanceDaysSelect">
		<?php 
		for($i = 1; $i <= 10; $i++){
		?>
		<option value="<?= $i?>"><?= $i?></option>
		<?php
		}?>
	</select> Días
	<div class="modal-footer">    
		<button class="btn btn-primary" id="assignAdvanceDays" onclick='assignAdvanceDays("<?= base_url()?>/Administrator_controller/assignAdvanceDays")' value="Asignar">
			Guardar
		</button>
	</div>
	<div id="loader" style="left: 45%;"></div>
</div>