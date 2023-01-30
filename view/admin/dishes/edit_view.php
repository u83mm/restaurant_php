<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Platos";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h3 class="text-center">CARACTERÍSTICAS DEL PLATO</h3>
    <div class="col-12 col-md-9 col-lg-7 col-xl-6 mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="hidden" name="dishe_id" value="<?php echo $dishe['dishe_id']?>">
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="name">Nombre:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $dishe['name']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="description">Descripción:</label>
                <div class="col-sm-8">
                    <textarea class="form-control"name="description" id="description" cols="30" rows="10" required><?php echo $dishe['description']; ?></textarea>                    
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="price">Precio:</label>
                <div class="col-sm-2">
                    <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php echo $dishe['price']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="category">Categoría:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <select name="category" id="category">
                        <option value="<?php echo $dishe['category_id']; ?>"><?php echo ucfirst($dishe['category_name']); ?></option>
                    <?php foreach ($categoriesDishesDay as $key => $category) { ?>
                        <option value="<?php echo $category["category_id"]; ?>"><?php echo ucfirst($category["category_name"]); ?></option>
                    <?php } ?>
                    </select>                   
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="dishes_type">Tipo de Plato:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <select name="dishes_type" id="dishes_type">
                        <option value="<?php echo $disheType['menu_id']; ?>"><?php echo ucfirst($disheType['menu_category']); ?></option>
                    <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                        <option value="<?php echo $category["menu_id"]; ?>"><?php echo ucfirst($category["menu_category"]); ?></option>
                    <?php } ?>
                    </select>                   
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label">Imagen:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <a href="/menu/info_dishe/show_info.php?id=<?php echo $dishe['dishe_id']; ?>">
                        <img class="img-fluid w-50" src="<?php echo $dishePicture; ?>" alt="dishe_image"> 
                    </a>                                    
                </div>                
            </div>
            <div class="row mb-3">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />  
                <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="dishe_img">Cambiar Imagen:</label>
                <div class="col-12 col-md-8 input-group inputFile">
                    <input type="file" id="dishe_img" name="dishe_img" />
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end col-form-label">Disponible:</label>
                <div class="col-12 col-md-8 text-center text-md-start">
                    <?php if($dishe['available'] === "SI") {?>
                        <input type="checkbox" name="available" id="available" value="SI" checked> 
                    <?php }else { ?>                    
                        <input type="checkbox" name="available" id="available" value="SI"> 
                    <?php } ?>
                </div>                
            </div>
                          
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end" for="nome">&nbsp;</label>
                <div class="col-12 col-md-8 text-center text-sm-start">                   
                    <button type="submit" name="action" value="update">Actualizar</button>                   
                    <input type="submit" name="action" value="Volver">
                </div>                
            </div>                                                              
        </form>        
    </div>    
<?php
	$page->do_html_footer();
?>