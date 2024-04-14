<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | " . ucfirst($page->language['nav_link_sign_up']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_sign_up']);
?>	
    <div class="col-12 col-md-6 mx-auto credentials">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <h3 class="text-center"><?php echo strtoupper($page->language['register_form']); ?></h3>
        <form action="#" method="post">            
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="user_name">User:</label>
                <div class="col-12 col-md-8">
                    <input class="form-control" type="text" name="user_name" id="user_name" value="<?php if(isset($fields['user_name'])) echo $fields['user_name']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="password">Password:</label>
                <div class="col-12 col-md-8">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end  col-form-label" for="email">Email:</label>
                <div class="col-12 col-md-8">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" required>
                </div>                
            </div>               
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end">&nbsp;</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <input type="submit" value="<?php echo ucfirst($page->language['send']); ?>">
                </div>                
            </div>                                                              
        </form>
    </div>    
<?php
	$page->do_html_footer();
?>