<aside class="col-12 col-lg-3 mb-5 menuDia">		
    <div class="row text-center mb-3">
        <div class="col d-flex justify-content-center align-items-center">
            <h2 class="col-8"><?php echo ucfirst($home->language['day_menu']); ?></h2>
            <img class="col-3 img-fluid" src="/images/menu_dia_logo.webp" alt="menu-logo">            
        </div>        				
    </div>
    <hr>
    <!-- Primeros -->
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['first_plates']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($menuDaySections['main'] as $key => $plato) { ?>                
                <li><em><a href="/menu/showDisheInfo/<?php echo $plato['dishe_id']; ?>"><?php if(isset($plato['name'])) echo ucfirst($plato['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>

    <!-- Segundos -->
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['seconds']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($menuDaySections['second'] as $key => $plato) { ?>
                <li><em><a href="/menu/showDisheInfo/<?php echo $plato['dishe_id']; ?>"><?php if(isset($plato['name'])) echo ucfirst($plato['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>

    <!-- Postres -->
    <div class="row mb-3">
        <h4 class="text-center"><strong><?php echo strtoupper($home->language['desserts']); ?></strong></h4>
        <ul class="ps-4">
            <?php foreach ($menuDaySections['dessert'] as $key => $postre) { ?>
                <li><em><a href="/menu/showDisheInfo/<?php echo $postre['dishe_id']; ?>"><?php if(isset($postre['name'])) echo ucfirst($postre['name']); ?></a></em></li>
            <?php } ?>
        </ul>
    </div>
    <hr>

    <h4><strong><?php echo strtoupper($home->language['price']); ?>: <?php echo number_format($menuDaySections['price'], 2, ",", "."); ?>&nbsp;€</strong></h4>
    <p class="text-start">*<?php echo strtoupper($home->language['drink']); ?>: <?php echo $home->language['menu_day_footer']; ?></p>
</aside>