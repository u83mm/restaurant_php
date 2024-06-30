<?php	
	use model\classes\PageClass;

	$home = new PageClass();
    $home->title = ucfirst($home->language['users']) . " | " . ucfirst($home->language['change_password']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_administration']);
?>	
    <div class="col-12 col-md-6 mx-auto credentials">
        <?php echo $message ?? ""; ?>
        <h3 class="text-center"><?php echo mb_strtoupper($home->language['change_password']); ?></h3>
        <form action="/admin/admin/changePassword/<?php echo $id; ?>" method="post"> 
            <input type="hidden" name="id_user" value="<?php echo $id; ?>">           
            <div class="row mb-3">
                <label class="col-12 col-sm-4 text-center text-md-end col-form-label" for="password"><?php echo ucfirst($home->language['password']); ?>:</label>
                <div class="col-10 col-sm-6 pe-0">
                    <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($fields['password'])) echo $fields['password']; ?>" required>
                </div> 
                <div class="col-1 col-md-1 ms-2 me-2 m-md-0 d-flex p-0 justify-content-center align-items-center">
                    <img class="show_password" src="/images/eye.svg" alt="eye" height="20">
                </div>                 
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-4 text-center text-md-end col-form-label" for="new_password"><?php echo ucfirst($home->language['repeat_password']); ?>:</label>
                <div class="col-10 col-sm-6 pe-0">
                    <input class="form-control" type="password" name="new_password" id="new_password" value="<?php if(isset($fields['new_password'])) echo $fields['new_password']; ?>" required>
                </div>
                <div class="col-1 col-sm-1 ms-2 me-2 m-md-0 d-flex p-0 justify-content-center align-items-center">
                    <img class="show_password" src="/images/eye.svg" alt="eye" height="20">
                </div>               
            </div>
            <div class="row mb-3">
                <label class="col-12 text-center text-center col-form-label" for="strength">Strength Password:</label>
                <div id="strength" class="col-12 strength">                                        
                    <div class="strength_bar" id="strength_bar"></div>                                    
                </div>
                <p class="message" id="message"></p>
            </div>                        
            <div class="row mb-3 justify-content-center align-content-center">                
                <div class="col-12 col-sm-5 col-xl-4 mb-2 mb-md-0">
                    <button class="btn btn-outline-success" type="submit" name="action" value="change password"><?php echo ucwords($home->language['change_password']); ?></button>                                    
                </div>
                <div class="col-sm-5 col-xl-3">                    
                    <a class="btn btn-primary mb-5" href="/admin/admin/show/<?php echo $id; ?>"><?php echo ucfirst($home->language['go_back']); ?></a>
                </div>                
            </div>                                                              
        </form>        
    </div> 
    <script src="/js/passwd_test_strength.js"></script>	    
<?php
	$home->do_html_footer();
?>