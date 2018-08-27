<?= form_open("/Login/LoginRespuesta") ?>

<?php
	$user = array(
		'name' => 'usuario',
		'placeholder' => 'Digite su usuario'
	);
	$password = array(
		'name' => 'contrasena',
		'placeholder' => 'Digite su contraseña'
	);
?>
<body>
	<?= $string ?>
	<?= form_label('Usuario ', 'user') ?>
	<?= form_input($user) ?>

	<?= form_label('Contraseña ', 'password') ?>
	<?= form_input($password) ?>

	<?= form_submit('', 'Iniciar Sesión') ?>
	<?= form_close() ?>
</body>