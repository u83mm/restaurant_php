<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Comandas";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "orders");
?>	
								<!--- SECTION WITH INFO -->
	<h3 class="text-center">NUEVO PEDIDO</h3>
    <div class="col-12 mx-auto">
        <?php echo $message = $this->message ?? ""; ?>
        <?php include(SITE_ROOT . "/../view/orders/form_view.php") ?>    
    </div>  		
<?php
	$home->do_html_footer();
?>