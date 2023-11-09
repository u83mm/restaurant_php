<?php	
	use model\classes\PageClass;

	$home = new PageClass();
    $home->title = "My Restaurant | Search";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>	
    <div class="row">
        <h3 class="text-center pb-2"><?php echo ucwords($home->language['search_reservations']); ?></h3>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?> 
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center"><?php echo ucfirst($home->language['search_criteria']); ?></h4>                                    
            <div class="row mb-3">               

                <!-- By date and time(optional) -->

                <h5 class="text-center"><?php echo ucfirst($home->language['date_hour-optional']); ?></h5> 
                <form class="text-center mb-3" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="mb-3">                                        
                    <div class="col-sm-7 col-md-5 col-lg-5 d-inline-block">
                        <input class="form-control" type="date" name="date" id="date" required>                        
                    </div> 
                    <div class="col-sm-5 col-md-4 col-lg-4 d-inline-block">                        
                        <select name="time">
                            <option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
                            <?php foreach ($hours as $key => $value) :?>
                             <option value="<?php echo $value; ?>"><?php echo number_format($value, 2); ?></option>       
                            <?php endforeach ?>
                        </select>
                    </div> 
                    <button class="btn btn-primary mt-3 mt-md-0" name="action" value="search"><?php echo ucfirst($home->language['search']); ?></button>                 
                </form>
                <hr> 
                
                <!-- All the reservations order by time -->

                <h5 class="text-center"><?php echo ucfirst($home->language['all_reservations']); ?></h5> 
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="mb-3">                    
                    <button class="btn btn-primary" name="action" value=""><?php echo ucfirst($home->language['search']); ?></button>                                    
                </form>
            </div>            
        </div>

        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">TEXTO</h4>            
        </div>
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">TEXTO</h4>            
        </div>                                                                                        
    </div>  
    <div class="col-12 col-lg-6 mx-auto">                
		<form action="/admin/admin.php" method="post">
            <input type="hidden" name="action" value="admin_menus">
            <button type="submit" class="btn btn-primary mb-5" value="volver"><?php echo ucfirst($home->language['go_back']); ?></button>
        </form>
    </div>
<?php
	$home->do_html_footer();
?>