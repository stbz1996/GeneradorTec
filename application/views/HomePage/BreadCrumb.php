<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php 
        foreach($iters as $element) { ?>
            <li class="breadcrumb-item">
                <a href="<?=base_url()?><?= $element['HTML']?>"><?= $element['NAME'] ?></a>
            </li>  
        <?php  } ?>
        <li class="breadcrumb-item active" aria-current="page"><?= $actual ?></li>
    </ol>
</nav>