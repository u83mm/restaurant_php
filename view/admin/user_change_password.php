<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>
	<h3 class="text-center">CHANGE PASSWORD</h3>
    <div class="col-6 mx-auto">
        <?php echo $message = $this->message ?? ""; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">           
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="password">Password:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label" for="new_password">Repeat Password:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="new_password" id="new_password" required>
                </div>                
            </div>               
            <div class="row mb-3">
                <label class="col-sm-4" for="nome">&nbsp;</label>
                <div class="col-sm-6">
                    <input class="btn btn-outline-success" type="submit" name="action" value="Change Password">                    
                </div>                
            </div>                                                              
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">  
            <input type="hidden" name="action" value="show">
            <input type="submit" class="btn btn-primary mb-5" value="Volver">
        </form>
    </div>    
<?php
	$home->do_html_footer();
?>