<main class="page-content">
	<div class="container-fluid">
		<div class="row">

			<div class="sidebar-header" id="planHeader">
                <img class="img-responsive" id="image1" src="https://tecdigital.tec.ac.cr/servicios/capacitacion/guia_estudiantes/resources/images/tec.png">
            </div>

            <br></br>
            <hr class="style3">

            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?=base_url()?>/index.php/Administrator_controller">Inicio</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?=base_url()?>/index.php/Carreras_controller">Carreras</a></li>
                <li class="breadcrumb-item active" aria-current="page">Planes</li>
              </ol>
            </nav>

            <ul class="list-group">

                <? foreach($plans as $plan): ?>
                    <li class="list-group-item">
                        <div class="col-sm-8">
                            <a href="<?=base_url()?>/index.php/Administrator_controller/Courses">
                                <h3 class=list-group-item-heading><?= $plan->getName()?></h3>
                            </a>
                        </div>

                        <div class="col-sm-4">
                            <span class="pull-right">
                                <a href="<?=base_url()?>/index.php/Administrator_controller/changeStatePlan" 
                                    style="text-decoration: none;">

                                    <? if ($plan->getState()): ?>
                                        <span class="glyphicon glyphicon-ok-circle"></span>
                                    <?else:?>
                                        <span class="glyphicon glyphicon-remove-circle"></span>
                                    <? endif; ?>
                                </a>

                                <a href="<?=base_url()?>/index.php/Administrator_controller/editPlan" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="<?=base_url()?>/index.php/Administrator_controller/deletePlan" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                <a href="<?=base_url()?>/index.php/Administrator_controller/Courses" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </span>
                        </div>
                    </li>
                <? endforeach; ?>

                <li class="list-group-item" style="border-bottom: none; border-right: none; border-left: none;">
                    <a href="" style="text-decoration: none;">
                        <button type="button" class="btn btn-primary" id="botonAdd">Agregar nuevo plan</button>
                    </a>
                </li>
            </ul>

            <hr class="style3">

            <div>
            	Aqui los botones
            </div>

		</div>
    </div>
</main>