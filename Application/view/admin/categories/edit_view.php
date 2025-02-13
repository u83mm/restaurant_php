<?php	
	use Application\model\classes\PageClass;

	$page = new PageClass();
	$page->title = ucfirst($page->language['dishes']) . " | " . ucfirst($page->language['new']);			

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['edit']); ?></h3>
	<?php echo $_SESSION['message'] ?? $message ?? "" ?>
    <div class="col-12 col-md-9 col-lg-7 col-xl-6 mx-auto">        
        <?php include(SITE_ROOT. "/../Application/view/admin/categories/form_view.php"); ?>                		
    </div>
<?php
	$page->do_html_footer();
?>