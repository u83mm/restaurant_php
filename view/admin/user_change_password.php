<?php	
	use model\classes\PageClass;

	$home = new PageClass();
    $home->title = ucfirst($home->language['users']) . " | " . ucfirst($home->language['change_password']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>
	<h3 class="text-center"><?php echo strtoupper($home->language['change_password']); ?></h3>
    <div class="col-6 mx-auto">
        <?php echo $message = $this->message ?? ""; ?>
        <form action="/admin/admin/changePassword/<?php echo $id; ?>" method="post"> 
            <input type="hidden" name="id_user" value="<?php echo $id; ?>">           
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="password"><?php echo ucfirst($home->language['password']); ?>:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="new_password"><?php echo ucfirst($home->language['repeat_password']); ?>:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="new_password" id="new_password" required>
                </div>                
            </div>                       
            <div class="row mb-3">
                <label class="col-sm-4" for="none">&nbsp;</label>
                <div class="col-12 col-sm-3 mb-2 mb-md-0">
                    <button class="btn btn-outline-success" type="submit" name="action" value="change password"><?php echo ucwords($home->language['change_password']); ?></button>                                    
                </div>
                <div class="col-sm-4">                    
                    <a class="btn btn-primary mb-5" href="/admin/admin/show/<?php echo $id; ?>"><?php echo ucfirst($home->language['go_back']); ?></a>
                </div>                
            </div>                                                              
        </form>        
    </div>    
<?php
	$home->do_html_footer();
?>