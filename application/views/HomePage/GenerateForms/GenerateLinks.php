<div class="titles" id="titles">
  	<h1>Generación automática de links</h1>
   	<ul>
		<li type="disc"> 
			Aquí se muestran los profesores activos a los que se les enviará en link para el periodo seleccionado.
		</li>
		<li type="disc"> 
			El link solo será enviado si no ha sido enviado antes para el periodo seleccionado. 
		</li>
	</ul>
  	<p></p>
    </div>
    <hr>
    <form id="LinksForm">
        <div class="containerDate">
			<h4>Seleccione la fecha de vencimiento de los formularios</h4>
				<input id="dateForLinks" class="dateInput" required type="date" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
		</div> 
		<div class="containerDate">
		    <h4>Seleccione el periodo de validez de los formularios</h4>
			<select id="periodForLinks" class="form-control" name="period" required>
			<?php 
				if ($periods) {
				foreach ($periods as $p) { ?>
					<option value=<?= $p->idPeriod ?>> <?= $p->number.' - '.$p->year ?></option>
			<?php } 
				} ?>
			</select>
		</div>
        <hr>
            
    	<!-- Shows the informatión of the profesors -->
    	<div class="forms">
           	<div class="message">
				<h3> <?= $_SESSION['LinksState'] ?> </h3>
			</div>
			<form>
				<div class="modal-body">
					<table class="profesorsTable">
						<tr>
							<td class="indicationsTable">ID</td>
						    <td class="indicationsTable">Profesor</td>
						    <td class="indicationsTable">Correo</td>
						</tr>
						<?php 
							if ($profesors) {
							$num = 1;
							foreach ($profesors as $p) { ?>
								<tr>
									<td class="numberTable"> <?= $num ?> </td>
								    <td class="profesorTable"><?= $p->name." ".$p->lastName ?></td>
								    <td class="emailTable"><?= $p->email ?></td>
								</tr>
						<?php $num = $num + 1; }
							} ?>
					</table>
				</div>
				<div class="modal-footer">
					<input type="button" name="sendData" value="Enviar Links" class="btn btn-primary" onclick="showEmailSent()">
				</div>
			</form> 
		</div>
	</form>
<div id="loader"></div>