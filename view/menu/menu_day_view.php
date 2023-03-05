<aside class="col-12 col-lg-3 mb-3 menuDia">		
    <div class="row text-center mb-3">
        <div class="col d-flex justify-content-center align-items-center">
            <h3>Menú del día</h3>
            <img class="img-fluid" src="/images/menu_dia_logo.png" alt="menu-logo">
        </div>				
    </div>		
    <div class="row mb-3">
        <h4 class="text-center"><strong>PRIMEROS PLATOS</strong></h4>
        <ul class="ps-4">
            <?php foreach ($primeros as $key => $plato) { ?>
                <li><?php echo ucfirst($plato['name']); ?></li>
            <?php } ?>
        </ul>
    </div>
    <div class="row mb-3">
        <h4 class="text-center"><strong>SEGUNDOS PLATOS</strong></h4>
        <ul class="ps-4">
            <?php foreach ($segundos as $key => $plato) { ?>
                <li><?php echo ucfirst($plato['name']); ?></li>
            <?php } ?>
        </ul>
    </div>
    <div class="row mb-3">
        <h4 class="text-center"><strong>POSTRE</strong></h4>
        <ul class="ps-4">
            <?php foreach ($postres as $key => $postre) { ?>
                <li><?php echo ucfirst($postre['name']); ?></li>
            <?php } ?>
        </ul>
    </div>
                            
    <h4><strong>PRECIO: <?php echo number_format($menuDayPrice, 2, ",", "."); ?>&nbsp;€</strong></h4>
    <p>*Bebida a elegir, agua, vino o refresco</p>
</aside>