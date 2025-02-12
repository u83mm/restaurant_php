<?php	
	use Application\model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Admin";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
    <div class="row mb-4">
        <h3 class="text-center pb-3"><?php echo mb_strtoupper($page->language['main_menu']); ?></h3>
        <?php echo $message ?? ""; ?>
        
                                            <!-- PLATOS -->

        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['products']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <div class="row">
                    <div class="col">
                        <a class="btn btn-primary" href="/admin/dishes/index"><?php echo ucfirst($page->language['show_list']); ?></a>
                        <a class="btn btn-primary" href="/admin/dishes/search"><?php echo ucfirst($page->language['search']); ?></a>
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
        </section>
                                            <!-- USUARIOS -->

        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['users']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <form action="/admin/admin/index" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="listado"><?php echo ucfirst($page->language['show_list']); ?></button></form>
            </div>
        </section>
                                            <!-- CATEGORIAS -->

        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo mb_strtoupper($page->language['categories']); ?></h4>
            <div class="shadow rounded adminMenus">            
                <a class="btn btn-primary mb-5" href="/admin/categories/index"><?php echo ucfirst($page->language['show_list']); ?></a>
            </div> 
        </section>                                                                                                                                                                                                                                           
    </div>
        
    <div class="row mb-4">
                                            <!-- COMANDAS -->
        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['orders']); ?></h4>
            <div class="shadow rounded adminMenus">
                <form action="/admin/comandas/index" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="index"><?php echo ucfirst($page->language['show_list']); ?></button></form>
            </div>
        </section>
                                            <!-- RESERVATIONS -->

        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center"><?php echo strtoupper($page->language['reservations']); ?></h4>
            <div class="shadow rounded adminMenus">
                <form action="/reservations/reservation/showSearchPanel" method="post"><button type="submit" class="btn btn-primary mb-5 d-inline-block" name="action" value="search_panel"><?php echo ucfirst($page->language['search']); ?></button></form>
            </div>
        </section>
                                            <!-- NEW SECTION -->

        <section class="col-12 col-md-6 col-lg-4 mb-4">
            <h4 class="text-center">&nbsp;</h4>
            <div class="shadow rounded adminMenus">

            </div>
        </section>                                                                    
    </div>
<?php
	$page->do_html_footer();
?>