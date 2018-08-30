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
		'name' => 'submitButton',
		'value' => 'Nuevo Administrador',
		'class' => 'btn btn-primary'
	);
?>

<body id="LoginForm">
	<div class="container">
		<div class="login-form">
			<div class="main-div">
		    	<div class="panel">
		   			<h2>Administración</h2>
		   			<p>Por favor ingrese la información del nuevo administrador: </p>
		   		</div>
		    	<form id="Login">
		        	<div class="form-group"> <?= form_input($user) ?> </div>
		        	<div class="form-group"> <?= form_input($password) ?> </div>
		        	<div class="form-group"> <?= form_input($passwordAgain) ?> </div>
		        	<?= form_submit($button) ?>
		   		</form>
    		</div>
		</div>
	</div>
</body>
<?= form_close() ?> 