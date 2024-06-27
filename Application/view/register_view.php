<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | " . ucfirst($page->language['nav_link_sign_up']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_sign_up']);
?>	
    <div class="col-12 col-md-6 mx-auto credentials">
        <?php echo $message ?? ""; ?>
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
                <div class="col-10 col-md-7 pe-0">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
                </div>
                <div class="col-1 col-md-1 ms-2 me-2 m-md-0 d-flex p-0 justify-content-center align-items-center">
                    <img class="show_password" src="/images/eye.svg" alt="eye" height="20">
                </div>                   
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end  col-form-label" for="email">Email:</label>
                <div class="col-12 col-md-8">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 text-center col-form-label" for="strength">Strength Password:</label>
                <div id="strength" class="col-12 strength">                                        
                    <div class="strength_bar" id="strength_bar"></div>                                    
                </div>
                <p class="message" id="message"></p>
            </div>             
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end">&nbsp;</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <input type="submit" value="<?php echo ucfirst($page->language['send']); ?>">
                </div>                
            </div>                                                              
        </form>
    </div> 
    <script src="/js/passwd_test_strength.js"></script>	   
<?php
	$page->do_html_footer();
?>