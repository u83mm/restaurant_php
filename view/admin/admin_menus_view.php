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