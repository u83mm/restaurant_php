<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['orders']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_orders']);
?>	
								<!--- SECTION WITH INFO -->
	<h3 class="text-center"><?php echo strtoupper($home->language['new_order']); ?></h3>
    <div class="col-12 mx-auto">
        <?php echo $message ?? ""; ?>
        <?php include(SITE_ROOT . "/../Application/view/orders/form_view.php") ?>    
    </div>  		
<?php
	$home->do_html_footer();
?>