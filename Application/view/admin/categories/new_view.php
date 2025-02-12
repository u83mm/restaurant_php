<?php	
	use Application\model\classes\PageClass;

	$page = new PageClass();
	$page->title = ucfirst($page->language['dishes']) . " | " . ucfirst($page->language['new']);			

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['new_category']); ?></h3>
    <div class="col-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
        <?php echo $message ?? ""; ?>
        <?php //include(SITE_ROOT. "/../Application/view/admin/categories/form_view.php"); ?>
        
        <form id="categories-form" action="#" method="post">
            <div class="mb-3">
                <label for="category" class="form-label col-lg-3"><?php echo ucfirst($page->language['category']); ?></label>
                <div class="col-lg-7 d-inline-block">
                    <input type="text" class="form-control" id="category" name="category" required>
                </div>                
            </div>
            <div class="mb-3">
                <label for="emoji" class="form-label col-lg-3">Emoji</label>
                <div class="col-lg-7 d-inline-block">
                    <input type="text" class="form-control" id="emoji" name="emoji" required>
                </div>                
            </div>
            <div class="mb-3">
                <label class="col-lg-3" for="none">&nbsp;</label>
                <div class="col-lg-7 d-inline-block">
                    <button type="submit" class="btn btn-outline-primary mt-0"><?php echo ucfirst($page->language['save']); ?></button>
                    <a class="btn btn-outline-primary mb-5" href="/admin/categories/index"><?php echo ucfirst($page->language['go_back']); ?></a>
                </div>                
            </div>
        </form>		
    </div>
<?php
	$page->do_html_footer();
?>