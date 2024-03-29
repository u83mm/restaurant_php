<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Admin";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
    <div class="row mb-4">
        <h3 class="text-center pb-3"><?php echo mb_strtoupper($page->language['main_menu']); ?></h3>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        
                                            <!-- PLATOS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['products']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <div class="row">
                    <div class="col-6 col-md-4">
                        <a class="btn btn-primary mb-5" href="/admin/dishes/index"><?php echo ucfirst($page->language['show_list']); ?></a> 
                    </div>
                    <div class="col-6 col-md-3">
                        <a class="btn btn-primary" href="/admin/dishes/search"><?php echo ucfirst($page->language['search']); ?></a>
                    </div><div class="col-6 col-md-3">
                        <a class="btn btn-primary" href="/admin/dishes/showForm"><?php echo ucfirst($page->language['new']); ?></a>
                    </div>                
                </div>            
                <hr />
                <h4 class="text-center"><?php echo mb_strtoupper($page->language['menu_day_price']); ?></h4>
                <div class="row">
                    <form action="/admin/menuDay/index" method="post">
                        <button class="btn btn-primary" name="action" value="index"><?php echo ucfirst($page->language['send']); ?></button>
                        <div class="col-4 col-md-3 col-lg-4 text-center text-sm-start d-inline-block ms-2">
                            <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php //if(isset($fields)) echo $fields['Price']; ?>" required>
                        </div>                  
                    </form>                                             
                </div>            
            </div>
        </div>
                                            <!-- USUARIOS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['users']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <form action="/admin/admin/index" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="listado"><?php echo ucfirst($page->language['show_list']); ?></button></form>
            </div>
        </div>
                                            <!-- CATEGORIAS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo mb_strtoupper($page->language['categories']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <a class="btn btn-primary mb-5" href="#"><?php echo ucfirst($page->language['show_list']); ?></a>
            </div> 
        </div>                                                                                                                                                                                                                                           
    </div>
        
    <div class="row mb-4">
                                            <!-- COMANDAS -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['orders']); ?></h4>
            <div class="shadow rounded adminMenus">
                <form action="/admin/admin_comandas.php" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="index"><?php echo ucfirst($page->language['show_list']); ?></button></form>
            </div>
        </div>
                                            <!-- RESERVATIONS -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['reservations']); ?></h4>
            <div class="shadow rounded adminMenus">
                <form action="/reservations/reservation/showSearchPanel" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="search_panel"><?php echo ucfirst($page->language['search']); ?></button></form>
            </div>
        </div>
                                            <!-- NEW SECTION -->

        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">&nbsp;</h4>
            <div class="shadow rounded adminMenus">

            </div>
        </div>                                                                    
    </div>
<?php
	$page->do_html_footer();
?>