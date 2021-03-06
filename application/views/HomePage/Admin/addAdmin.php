<script>var base_url = '<?php echo base_url() ?>';</script>

<?php
	$user = array(
		'name' => 'inputUsername',
		'placeholder' => 'Usuario',
		'class' => 'form-control',
		'type' => 'text',
		'id' => 'username',
		'minlength' => '4',
		'maxlength' => '10'
	);
	$password = array(
		'name' => 'inputPassword',
		'placeholder' => 'Contraseña',
		'class' => 'form-control',
		'type' => 'password',
		'id' => 'inputPassword',
		'minlength' => '8',
		'maxlength' => '20'
	);
	$passwordAgain = array(
		'name' => 'inputPasswordAgain',
		'placeholder' => 'Repita contraseña',
		'class' => 'form-control',
		'type' => 'password',
		'id' => 'inputPasswordAgain',
		'minlength' => '8',
		'maxlength' => '20'
	);	
	$button = array(
		'name' =>  'submitButton',
		'value' => 'Agregar administrador',
		'class' => "btn btn-primary",
		'onclick' => "addAdmin()"
	);
?>

<div>
    <h1 class="tittles">Administración</h1>
  	<p>Por favor ingrese la información del nuevo administrador: </p>
</div>
<div class="adminContainer" id="allcontent">
	<div class="row">
        <div>
         	<form id="Login">
	        	<div class="form-group"> <?= form_input($user) ?> </div>
	        	<div class="form-group"> <?= form_input($password) ?> </div>
	        	<div class="form-group"> <?= form_input($passwordAgain) ?> </div>
	   		</form>
        </div>            
        <div class="modal-footer">
          	<?= form_submit($button) ?>
        </div>
		<?= form_close() ?> 
	</div>
</div>

  <div id="loader" style="left: 45%;"></div>
