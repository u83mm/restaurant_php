<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Admin";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links);
?>
    <div class="row mb-4">
        <h3 class="text-center pb-3">MENÚ PRINCIPAL</h3>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        
                                            <!-- PLATOS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">PRODUCTOS</h4>
            <div class="w-100 bg-success bg-opacity-10 adminMenus">            
                <div class="row">
                    <div class="col-3">
                        <a class="btn btn-primary mb-5" href="/admin/admin_dishes.php">Listado</a> 
                    </div>
                    <div class="col-3">
                        <form class="text-center text-lg-start d-inline" action="/admin/admin_dishes.php" method="post">                                
                            <button type="submit" class="btn btn-primary" name="action" value="search">Buscar</button>               
                        </form>
                    </div><div class="col-3">
                        <form class="text-center text-lg-start d-inline" action="/admin/admin_dishes.php" method="post">                                
                            <button type="submit" class="btn btn-primary" name="action" value="show_form">Nuevo</button>               
                        </form>
                    </div>                
                </div>            
                <hr />
                <h4 class="text-center">PRECIO MENÚ DÍA</h4>
                <div class="row">
                    <form action="/admin/admin_menu_day_price.php" method="post">
                        <button class="btn btn-primary" name="action" value="index">Enviar</button>
                        <div class="col-4 col-md-3 col-lg-4 text-center text-sm-start d-inline-block ms-2">
                            <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php //if(isset($fields)) echo $fields['Price']; ?>" required>
                        </div>                  
                    </form>                                             
                </div>            
            </div>
        </div>
                                            <!-- USUARIOS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">USUARIOS</h4>
            <div class="w-100 bg-success bg-opacity-10 adminMenus">            
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><input type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="Listado"></form>
            </div>
        </div>
                                            <!-- CATEGORIAS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">CATEGORIAS</h4>
            <div class="w-100 bg-success bg-opacity-10 adminMenus">            
                <a class="btn btn-primary mb-5" href="<?php echo $_SERVER['PHP_SELF']; ?>">Listado</a>
            </div> 
        </div>                                                                                                                                                                                                                                           
    </div>
        
    <div class="row mb-4">
                                            <!-- COMANDAS -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">COMANDAS</h4>
            <div class="w-100 col-3 bg-success bg-opacity-10 adminMenus">
                <form action="/admin/admin_comandas.php" method="post"><input type="submit" class="btn btn-primary mb-5 d-inline-block" value="Listado"></form>
            </div>
        </div>
                                            <!-- NEW SECTION -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">&nbsp;</h4>
            <div class="w-100 col-3 bg-success bg-opacity-10 adminMenus">

            </div>
        </div>
                                            <!-- NEW SECTION -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">&nbsp;</h4>
            <div class="w-100 col-3 bg-success bg-opacity-10 adminMenus">

            </div>
        </div>                                                                    
    </div>
<?php
	$page->do_html_footer();
?>