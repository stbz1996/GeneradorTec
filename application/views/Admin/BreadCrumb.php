<main class="page-content">
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