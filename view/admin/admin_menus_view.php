<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Admin";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
    <div class="row">
        <h3 class="text-center pb-2">MENÚ PRINCIPAL</h3>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?> 
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">PLATOS</h4>
            <a class="btn btn-primary mb-5" href="/admin/admin_dishes.php">Listado</a>
            <hr />
            <h4 class="text-center">PRECIO MENÚ DÍA</h4>
            <div class="row mb-3">
                <form action="/admin/admin_menu_day_price.php" method="post">
                    <button class="btn btn-primary" name="action" value="index">Enviar</button>
                    <div class="col-4 col-md-3 col-lg-4 text-center text-sm-start d-inline-block ms-2">
                        <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php //if(isset($fields)) echo $fields['Price']; ?>" required>
                    </div>                  
                </form>                                             
            </div>            
        </div>
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">USUARIOS</h4>
            <form action="#" method="post"><input type="submit" class="btn btn-primary mb-5" name="action" value="Listado"></form>
        </div> 
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">CATEGORIAS</h4>
            <a class="btn btn-primary mb-5" href="#">Listado</a>
        </div>                                                                                   
    </div>  
<?php
	$page->do_html_footer();
?>