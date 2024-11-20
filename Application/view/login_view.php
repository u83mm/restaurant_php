<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Login";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "login");
?>	
    <div class="col-12 col-md-6 col-lg-5 mx-auto credentials">
        <?php echo $message; ?>
        <h3 class="text-center">Login</h3>
        <form action="/login" method="post">
            <input type="hidden" name="csrf_token" value="<?php if(isset($csrf)) echo $csrf; ?>">
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="email">Email:</label>
                <div class="col-12 col-md-8">
                    <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($fields['email'])) echo $fields['email']; ?>" required>
                </div>                
            </div> 
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="password">Password:</label>
                <div class="col-10 col-md-7 pe-0">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" autocomplete="new-password" placeholder="example: raJ0#s2!_dA" required>
                </div>
                <div class="col-1 col-md-1 ms-2 me-2 m-md-0 d-flex p-0 justify-content-center align-items-center">
                    <img class="show_password" src="/images/eye.svg" alt="eye" height="20">
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
                    <input type="submit" value="Login">
                </div>                
            </div>                                                              
        </form>
    </div>    	
    <script src="/js/passwd_test_strength.js"></script>	    
<?php
	$page->do_html_footer();
?>