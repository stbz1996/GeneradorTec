<?= form_open("/Administrator_controller/editPlan2") ?>

<?php
	$user = array(
		'name' => 'newName',
		'placeholder' => $pastName,
		'class' => 'form-control',
		'type' => 'text',
		'id' => 'username',
		'minlength' => '4',
		'maxlength' => '100'
	);
	$button = array(
		'name' => 'submitButton',
		'value' => 'Cambiar nombre',
		'class' => 'btn btn-primary'
	);
?>

<body id="LoginForm">
	<div class="container">
		<div class="login-form">
			<div class="main-div">
		    	<div class="panel">
		   			<h2>Editar nombre</h2>
		   			<p>Por favor ingrese el nombre del nuevo plan: </p>
		   		</div>
		    	<form id="Login">
		        	<div class="form-group"> <?= form_input($user) ?> </div>
		        	<?= form_hidden('id', $id) ?>
		        	<?= form_submit($button) ?>
		   		</form>
    		</div>
		</div>
	</div>
</body>
<?= form_close() ?> 