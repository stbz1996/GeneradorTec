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
                <? foreach($iters as $element): ?>
                    <li class="breadcrumb-item">
                        <a href="<?=base_url()?><?= $element['HTML']?>"><?= $element['NAME'] ?></a>
                    </li>
                <? endforeach; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= $actual ?></li>
              </ol>
            </nav>

            <ul class="list-group">

                <? foreach($listElement as $element): ?>
                    <li class="list-group-item">
                        <div class="col-sm-6">
                            <a href="<?=base_url()?><?= $ADD['ADDRESS_1']?>">
                                <h3 class=list-group-item-heading><?= $element['NAME']?></h3>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <span class="pull-right">

                            <? if ($STATE['STATE_CHANGE'] == 'VALID'): ?>
                                <a href="<?=base_url()?><?= $ADD['ADDRESS_2']?>"
                                    style="text-decoration: none;">
                                    <? if ($element['STATE']): ?>
                                        <span class="glyphicon glyphicon-ok-circle"></span>
                                    <?else:?>
                                        <span class="glyphicon glyphicon-remove-circle"></span>
                                    <? endif; ?>
                                </a>
                            <? endif; ?>
                            <? if ($STATE['STATE_EDIT'] == 'VALID'): ?>
                                <a href="<?=base_url()?><?= $ADD['ADDRESS_3']?>/<?= $element['ID'] ?>/<?= $element['NAME'] ?>" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-pencil" ></span>
                                </a>
                            <? endif; ?>
                            <? if ($STATE['STATE_DELETE'] == 'VALID'): ?>
                                <a href="<?=base_url()?><?= $ADD['ADDRESS_4']?>/<?= $element['ID'] ?>/<?= $element['NAME'] ?>" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            <? endif; ?>
                            <? if ($STATE['STATE_MOVE'] == 'VALID'): ?>
                                <a href="<?=base_url()?><?= $ADD['ADDRESS_5']?>/<?= $element['ID'] ?>/<?= $element['NAME'] ?>" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-folder-open" ></span>
                                </a>
                            <? endif; ?>
                            <? if ($STATE['STATE_GET'] == 'VALID'): ?>
                                <a href="<?=base_url()?><?= $ADD['ADDRESS_1']?>/<?= $element['ID'] ?>/<?= urlencode($element['NAME']); ?>" style="text-decoration: none;">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            <? endif; ?>

                            </span>
                        </div>
                    </li>
                <? endforeach; ?>

                <li class="list-group-item" style="border-bottom: none; border-right: none; border-left: none;">
                    <? if ($STATE['STATE_ADD'] == 'VALID'): ?>
                        <a style="text-decoration: none;">
                            <button type="button" class="btn btn-primary" id="botonAdd" onclick="addPlan()">Agregar nuevo plan</button>
                        </a>
                    <? endif; ?>
                </li>
            </ul>

            <hr class="style3">

            <div>
                Aqui los botones
            </div>

        </div>
    </div>
</main>