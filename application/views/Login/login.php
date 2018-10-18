<?php 
	$dir = base_url().'System_controller/validCredentials';
?>
<section class="login-block">
    <div class="container">
		<div class="row">
			<div class="col-md-4 login-sec">
			    <h2 class="text-center">TEC</h2>
			    
				<form class="login-form" action="<?= $dir ?>" method="post">
					<div class="form-group">
				    	<label for="exampleInputEmail1" class="text-uppercase">Usuario</label>
				    	<input name="username" type="text" class="form-control" placeholder="">
				    </div>
					<div class="form-group">
					    <label for="exampleInputPassword1" class="text-uppercase">Contraseña</label>
					    <input name="password" type="password" class="form-control" placeholder="">
					</div>
					<div class="form-check">
					  	<button type="submit" class="btn btn-login">
					  		Iniciar Sesión
					  	</button>
					</div>
				</form>
				<p class="messageText"> <?= $message ?> </p>
			</div>

			<div class="col-md-8 banner-sec">
			</div>
		</div>
	</div>
</section>