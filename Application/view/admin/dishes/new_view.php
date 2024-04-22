<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = ucfirst($home->language['dishes']) . " | " . ucfirst($home->language['new']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>
	<h3 class="text-center"><?php echo strtoupper($home->language['new_product']); ?></h3>
    <div class="col-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
        <?php echo $message ?? ""; ?>
        <?php include(SITE_ROOT. "/../Application/view/admin/dishes/form_view.php"); ?>		
		<a class="btn btn-primary mb-5" href="/admin/dishes/index"><?php echo ucfirst($home->language['go_back']); ?></a>
    </div>
<?php
	$home->do_html_footer();
?>