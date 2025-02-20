<?php	
	use Application\model\classes\PageClass;

	$home = new PageClass();
    $home->title = "My Restaurant | Search category";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_administration']);
?>	
    <div class="container">
        <?php echo $_SESSION['message'] ?? $message ?? ""; ?>        
        <h3 class="text-center pb-2"><?php echo strtoupper($home->language['search_category']); ?></h3>               
    </div>
    <div class="row justify-content-evenly">                
        <div class="col-12 col-md-5 mb-4 shadow rounded adminMenus">                                               
            <div class="row mb-3">
                <?php echo $form_message ?? ""; ?>               
                <h4 class="text-center"><?php echo ucfirst($home->language['category']); ?></h4> 
                <form class="text-center" action="<?php echo rtrim($_SERVER['REQUEST_URI'], "/") ?>" method="post" class="mb-3">
                    <input type="hidden" name="csrf_token" value="<?php if(isset($_SESSION['csrf_token'])) echo $_SESSION['csrf_token']; ?>">                                    
                    <button class="btn btn-primary"><?php echo ucfirst($home->language['search']); ?></button>
                    <div class="col-7 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <input class="form-control" type="text" name="category" id="category" placeholder="<?php echo ucfirst($home->language['place_holder_category']); ?>" required>
                    </div>                  
                </form>                                                                          
            </div>            
        </div>                                                                                           
    </div>  
    <div class="col-12 col-lg-6 mx-auto">                
        <a class="btn btn-primary mb-5" href="/admin/admin/adminMenus"><?php echo ucfirst($home->language['go_back']); ?></a>
    </div>
<?php
	$home->do_html_footer();
?>