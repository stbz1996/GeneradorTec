<?= form_open("/Login/checkAdmin") ?>

<?php
	$user = array(
		'name' => 'inputEmail',
		'placeholder' => 'Usuario',
		'class' => 'form-control',
		'type' => 'text',
		'id' => 'inputEmail',
		'minlength' => '4',
		'maxlength' => '10'
	);

	$password = array(
		'name' => 'inputPassword',
		'placeholder' => 'Contraseña',
		'class' => 'form-control',
		'type' => 'password',
		'id' => 'inputPassword',
		'minlength' => '4',
		'maxlength' => '10'
	);	

	$button = array(
		'name' => 'submitButton',
		'value' => 'Iniciar Sesión',
		'class' => 'btn btn-primary'
	);
?>


<body id="LoginForm">
	<div class="container">
		<div class="login-form">
			<div class="main-div">
		    	<div class="panel">
		   			<h2>Administración</h2>
		   			<p>Por favor ingrese el usuario y la contraseña</p>
		   		</div>
		    	<form id="Login">
		        	<div class="form-group"> <?= form_input($user) ?> </div>
		        	<div class="form-group"> <?= form_input($password) ?> </div>
		        	<?= form_submit($button) ?>
		   		</form>
		   		<p class="botto-text"> <?= $message ?> </p>
    		</div>
		</div>
	</div>
</body>
<?= form_close() ?> 