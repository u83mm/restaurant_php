<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 

                                            <!-- MESA Y PERSONAS -->

    <div class="row mb-4 col-12 col-md-8 mx-auto">
        <!-- Mesa -->
        <div class="col-6">
            <label class="col-12 col-md-4 text-center text-md-end col-form-label" for="table_number">Mesa:</label>
            <div class="col-12 col-md-7 d-inline-block text-center text-md-start">
                <select name="table_number" id="table_number" >
                    <option value="<?php if(isset($table_number)) echo $table_number; ?>"><?php if(isset($table_number)) echo $table_number; ?></option>
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
                <select name="people_qty" id="people_qty" >
                    <option value="<?php if(isset($people_qty)) echo $people_qty; ?>"><?php if(isset($people_qty)) echo $people_qty; ?></option>
                    <?php foreach ($persones as $persone): ?>
                    <option value="<?php echo $persone ?>"><?php echo $persone ?></option>
                    <?php endforeach ?>           
                </select>
            </div>     
        </div>                                  
    </div>    

                                            <!-- COMANDA -->
    
    <div class="row mb-3">
                                            <!-- Aperitivos -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Aperitivos</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->aperitifs as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="aperitifs_name[]" id="aperitifs_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="aperitif_qty[]" id="qty" value="<?php echo $item['qty']; ?>" size="3">
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>

                                            <!-- Primeros -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Primeros</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->firsts as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="firsts_name[]" id="firsts_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="firsts_qty[]" id="qty" value="<?php echo $item['qty']; ?>" size="3">
                        </div>                                                
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>

                                            <!-- Segundos -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Segundos</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->seconds as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="seconds_name[]" id="seconds_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="seconds_qty[]" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>

                                            <!-- Bebidas -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Bebidas</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->drinks as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="drinks_name[]" id="seconds_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="drinks_qty[]" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>

                                            <!-- Postres -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Postres</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->desserts as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="desserts_name[]" id="desserts_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="desserts_qty[]" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>

                                            <!-- Cafés y licores -->

        <div class="col-12 col-md-6 col-lg-4 mb-5">
            <h3 class="text-center">Cafés y Licores</h3>
            <div class="w-100 adminMenus menuDia">
                <ul class="ps-4">
                <?php foreach ($this->coffees as $item): ?>
                    <?php if(isset($item['name'])): ?>
                    <li>
                        <div class="col-9 d-inline-block">
                            <input type="hidden" name="coffees_name[]" id="coffees_name" value="<?php echo ucfirst($item['name']); ?>">
                            <?php echo ucfirst($item['name']); ?>
                        </div>
                        <div class="col-2 d-inline-block">
                            <input class="numberQty" type="number" name="coffees_qty[]" id="qty" value="<?php echo $item['qty'] ?>" size="3">
                        </div>
                    </li>
                    <?php endif ?>
                <?php endforeach ?>
                </ul>                
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-12 text-center">            
            <button class="btn btn-outline-success" type="submit" name="action" value="save">Enviar</button>
            <button class="btn btn-outline-primary" type="submit" name="action" value="reset_order">Nuevo Pedido</button>                       
        </div>  
    </div>                                                              
</form>