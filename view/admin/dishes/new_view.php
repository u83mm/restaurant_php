<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links);
?>
	<h3 class="text-center">NUEVO PLATO</h3>
    <div class="col-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <?php include(SITE_ROOT. "/../view/admin/dishes/form_view.php"); ?>
		<form action="#" method="post"><input type="submit" class="btn btn-primary mb-5" name="action" value="Volver"></form>
    </div>
<?php
	$home->do_html_footer();
?>