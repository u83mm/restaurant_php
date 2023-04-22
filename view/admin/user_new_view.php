<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<h3 class="text-center">NUEVO USUARIO</h3>
    <div class="col-12 col-md-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <?php include(SITE_ROOT. "/../view/admin/form_view.php"); ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="submit" class="btn btn-primary mb-5" name="action" value="Volver">
		</form>
    </div>
<?php
	$home->do_html_footer();
?>