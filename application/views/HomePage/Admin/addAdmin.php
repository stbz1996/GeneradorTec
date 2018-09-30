<?= form_open("/Administrator_controller/getAdminData") ?>

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
		'placeholder' => 'repita contraseña',
		'class' => 'form-control',
		'type' => 'password',
		'id' => 'inputPasswordAgain',
		'minlength' => '8',
		'maxlength' => '20'
	);	
	$button = array(
		'name' =>  'submitButton',
		'value' => 'Nuevo Administrador',
		'class' => "btn btn-primary"
	);
?>


<main class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div>
              	<h1>Administración</h1>
		   		<p>Por favor ingrese la información del nuevo administrador: </p>
            </div>
            <hr>
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
</main>