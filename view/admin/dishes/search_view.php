<?php	
	use model\classes\PageClass;

	$home = new PageClass();
    $home->title = "My Restaurant | Search";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links);
?>	
    <div class="row">
        <h3 class="text-center pb-2">BÚSCAR PLATO</h3>
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?> 
        <div class="mx-auto mb-3 bg-success bg-opacity-10 adminMenus">
            <h4 class="text-center">Criterios de búsqueda</h4>                                    
            <div class="row mb-3">
                <h5 class="text-center">Por nombre</h5> 
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="mb-3">
                    <input type="hidden" name="field" value="name">
                    <button class="btn btn-primary" name="action" value="search">Buscar</button>
                    <div class="col-7 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <input class="form-control" type="text" name="critery" id="name" placeholder="Nombre del plato" required>
                    </div>                  
                </form>
                <hr>
                <h5 class="text-center">Por disponibilidad</h5> 
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="mb-3">
                    <input type="hidden" name="field" value="available">
                    <button class="btn btn-primary" name="action" value="search">Buscar</button>
                    <div class="col-4 col-md-3 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <select name="critery" id="available" required>
                            <option value="">- Selecciona -</option>
                            <option value="SI">Disponibles</option>
                            <option value="NO">NO disponibles</option>
                        </select> 
                    </div>                  
                </form>
                <hr>
                <h5 class="text-center">Por categoría</h5>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="mb-3">
                    <input type="hidden" name="field" value="menu_id">
                    <button class="btn btn-primary" name="action" value="search">Buscar</button>
                    <div class="col-4 col-md-3 col-lg-8 text-center text-sm-start d-inline-block ms-2">
                        <select name="critery" id="category" required>
                            <option value="">- Selecciona -</option>
                        <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                            <option value="<?php echo $category["menu_id"]; ?>"><?php echo ucfirst($category["menu_category"]); ?></option>
                        <?php } ?>                          
                        </select> 
                    </div>                  
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
            <input type="submit" class="btn btn-primary mb-5" value="Volver">
        </form>
    </div>
<?php
	$home->do_html_footer();
?>