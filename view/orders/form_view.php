<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 

                                            <!-- MESA Y PERSONAS -->

    <div class="row mb-4 col-12 col-md-8 mx-auto">
        <!-- Mesa -->
        <div class="col-6">
            <label class="col-12 col-md-4 text-center text-md-end col-form-label" for="table_number">Mesa:</label>
            <div class="col-12 col-md-7 d-inline-block text-center text-md-start">
                <select name="table_number" id="table_number" required>
                    <option value="">- Selecciona -</option>
                    <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table ?>"><?php echo $table ?></option>
                    <?php endforeach ?>          
                </select>
            </div>
        </div>

         <!-- Personas -->
        <div class="col-6">
            <label class="col-12 col-md-4 text-center text-md-end col-form-label" for="people_qty">Personas:</label>
            <div class="col-12 col-md-7 d-inline-block text-center text-md-start">
                <select name="people_qty" id="people_qty" required>
                    <option value="">- Selecciona -</option>
                    <?php foreach ($persones as $persone): ?>
                    <option value="<?php echo $persone ?>"><?php echo $persone ?></option>
                    <?php endforeach ?>           
                </select>
            </div>     
        </div>                                  
    </div>
    <div class="row mb-5">
        <div class="col-12 text-center">
            <input type="submit" value="Aceptar">  
        </div>  
    </div>

                                        <!-- COMANDA -->
    
    <div class="row mb-3">
        <!-- Aperitivos -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Aperitivos</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($aperitifs as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Primeros -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Primeros</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($firsts as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>                                                
                    </li>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Segundos -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Segundos</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($seconds as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Bebids -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Bebidas</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($drinks as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Postres -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Postres</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($desserts as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Cafés -->
        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Cafés y Licores</h3>
            <div class="w-100 adminMenus menuDia">
                <?php foreach ($coffees as $item): ?>
                    <li>
                        <div class="col-8 d-inline-block">
                            <?php echo $item['name']; ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="qty" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                <?php endforeach ?>
            </div>
        </div>
    </div>                                                               
</form>