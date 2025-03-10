<?php	
	use Application\model\classes\PageClass;

	$home = new PageClass();
    $home->title = "My Restaurant | Search";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_administration']);
?>	
    <div class="row justify-content-evenly">
        <h3 class="text-center pb-2"><?php echo strtoupper($home->language['search_product']); ?></h3>
        <?php echo $message ?? ""; ?> 
        <div class="col-12 col-md-5 mb-4 shadow rounded adminMenus">                                               
            <div class="row mb-3">

                <!-- By name -->

                <h4 class="text-center"><?php echo ucfirst($home->language['by_name']); ?></h4> 
                <form action="<?php echo rtrim($_SERVER['REQUEST_URI'], "/") ?>" method="post" class="mb-3">
                    <?php echo $error_by_name ?? ''; ?>
                    <input type="hidden" name="field" value="name">
                    <button class="btn btn-primary" name="action" value="search"><?php echo ucfirst($home->language['search']); ?></button>
                    <div class="col-7 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <input class="form-control" type="text" name="critery" id="name" placeholder="<?php echo ucfirst($home->language['place_holder_dish_name']); ?>" required>
                    </div>                  
                </form>
                <hr>


                <!-- By availability -->

                <h4 class="text-center"><?php echo ucfirst($home->language['by_availability']); ?></h4> 
                <form action="<?php echo rtrim($_SERVER['REQUEST_URI'], "/") ?>" method="post" class="mb-3">
                    <input type="hidden" name="field" value="available">
                    <button class="btn btn-primary" name="action" value="search"><?php echo ucfirst($home->language['search']); ?></button>
                    <div class="col-4 col-md-3 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <select name="critery" required>
                            <option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
                            <option value="1"><?php echo ucfirst($home->language['availables']); ?></option>
                            <option value="0">NO <?php echo $home->language['availables']; ?></option>
                        </select> 
                    </div>                  
                </form>
                <hr>


                <!-- By category -->

                <h4 class="text-center"><?php echo ucfirst($home->language['by_category']); ?></h4>
                <form action="<?php echo rtrim($_SERVER['REQUEST_URI'], "/") ?>" method="post" class="mb-3">
                    <input type="hidden" name="field" value="menu_id">
                    <button class="btn btn-primary" name="action" value="search"><?php echo ucfirst($home->language['search']); ?></button>
                    <div class="col-4 col-md-3 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <select name="critery" id="category" required>
                            <option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
                        <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                            <option value="<?php echo $category["menu_id"]; ?>"><?php echo ucfirst($category["{$_SESSION['language']}_menu_category"]); ?></option>
                        <?php } ?>                          
                        </select> 
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