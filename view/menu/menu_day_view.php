<aside class="col-12 col-lg-3 mb-5 menuDia">		
    <div class="row text-center mb-3">
        <div class="col d-flex justify-content-center align-items-center">
            <h2 class="col-8"><?php echo ucfirst($home->language['day_menu']); ?></h2>
            <img class="col-3 img-fluid" src="/images/menu_dia_logo.png" alt="menu-logo">            
        </div>        				
    </div>
    <hr>		
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['first_plates']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($primeros as $key => $plato) { ?>
                <li><em><a href="/menu/info_dishe/show_info.php?id=<?php echo $plato['dishe_id']; ?>"><?php echo ucfirst($plato['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['seconds']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($segundos as $key => $plato) { ?>
                <li><em><a href="/menu/info_dishe/show_info.php?id=<?php echo $plato['dishe_id']; ?>"><?php echo ucfirst($plato['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['desserts']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($postres as $key => $postre) { ?>
                <li><em><a href="/menu/info_dishe/show_info.php?id=<?php echo $postre['dishe_id']; ?>"><?php echo ucfirst($postre['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>
    <hr>

    <h4><strong><?php echo strtoupper($home->language['price']); ?>: <?php echo number_format($menuDayPrice, 2, ",", "."); ?>&nbsp;€</strong></h4>
    <p>*Bebida a elegir, agua, vino o refresco</p>
</aside>