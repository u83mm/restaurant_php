<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = ucfirst($home->language['users']) . " | " . ucfirst($home->language['new']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>
	<h3 class="text-center"><?php echo strtoupper($home->language['new_user']); ?></h3>
    <div class="col-12 col-md-6 mx-auto">
        <?php echo $this->message; ?>
        <?php include(SITE_ROOT. "/../view/admin/form_view.php"); ?>
		<form action="/admin/admin/index" method="post">
			<input type="submit" class="btn btn-primary mb-5" name="action" value="<?php echo ucfirst($home->language['go_back']); ?>">
		</form>
    </div>
<?php
	$home->do_html_footer();
?>