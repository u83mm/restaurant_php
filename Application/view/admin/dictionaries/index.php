<?php	
	use Application\model\classes\PageClass;

	$page = new PageClass();
	$page->title = "My Restaurant | Dictionaries";			

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['dictionaries']); ?></h3>
    <?php extract($fields); ?>
	<?php echo $_SESSION['message'] ?? $message ?? "" ?>

    <div class="row mb-4">
        <!-- Spanish -->
        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo ucfirst($page->language['spanish']) ?><img class="dictionary-flag" src="/images/spanish-flag.svg" alt="Language flag" /></h4>        
            <div class="shadow rounded adminMenus">
                <form action="/admin/dictionaries/spanish" method="post">
                    <?php echo $sp_dict_message ?? "" ?>                   
                    <div class="col-12 mb-2 mb-md-0 col-md-4 d-inline-block">
                        <input type="text" class="form-control" name="key" id="sp-key" value="<?php if(isset($sp_key)) echo $sp_key; ?>" placeholder="Key word" required>
                    </div>
                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-inline-block">
                        <input type="text" class="form-control" name="value" id="sp-value" value="<?php if(isset($sp_value)) echo $sp_value; ?>" placeholder="Value">
                    </div>
                    <button type="submit" class="btn btn-primary d-inline-block"><?php echo ucfirst($page->language['send']) ?></button>                                          
                </form>
            </div>
        </section>

        <!-- English -->
        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo ucfirst($page->language['english']) ?><img class="dictionary-flag" src="/images/english-flag.svg" alt="Language flag" /></h4>        
            <div class="shadow rounded adminMenus">
                <form action="/admin/dictionaries/english" method="post">
                    <?php echo $en_dict_message ?? "" ?>                    
                    <div class="col-12 mb-2 mb-md-0 col-md-4 d-inline-block">
                        <input type="text" class="form-control" name="key" id="en-key" value="<?php if(isset($en_key)) echo $en_key; ?>" placeholder="Key word" required>
                    </div>
                    <div class="col-12 mb-2 mb-md-0 col-md-5 d-inline-block">
                        <input type="text" class="form-control" name="value" id="en-value" value="<?php if(isset($en_value)) echo $en_value; ?>" placeholder="Value">
                    </div>
                    <button type="submit" class="btn btn-primary d-inline-block"><?php echo ucfirst($page->language['send']) ?></button>                                        
                </form>
            </div>
        </section>
    </div>
    <a class="btn btn-outline-primary" href="/admin/admin/adminMenus"><?php echo ucfirst($page->language['go_back']); ?></a>   
<?php
	$page->do_html_footer();
?>