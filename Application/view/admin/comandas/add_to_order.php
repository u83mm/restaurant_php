<?php	
	use Application\model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['orders']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_orders']);
?>	
								<!--- SECTION WITH INFO -->
	<h3 class="text-center"><?php echo mb_strtoupper($home->language['add_to_order']); ?></h3>
    <div class="col-12 mx-auto">
        <?php echo $message ?? ""; ?>
        <?php include(SITE_ROOT . "/../Application/view/admin/comandas/add_to_order_form.php"); ?>    
    </div>  		
<?php
	$home->do_html_footer();
?>