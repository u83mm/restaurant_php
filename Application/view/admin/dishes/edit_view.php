<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = ucfirst($page->language['dishes']) . " | " . ucfirst($page->language['edit']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['product_details']); ?></h3>
    <div class="col-12 col-md-11 col-lg-8 col-xl-6 mx-auto">
        <?php echo $message ?? ""; ?>
        <form action="/admin/dishes/update/<?php echo $dishe['dishe_id']?>" method="post" enctype="multipart/form-data">           
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label" for="name"><?php echo ucfirst($page->language['name']); ?>:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo ucfirst($page->language[$dishe['name']]); ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label" for="description"><?php echo ucfirst($page->language['description']); ?>:</label>
                <div class="col-sm-8">
                    <textarea class="form-control"name="description" id="description" cols="30" rows="10" required><?php echo $dishe['description']; ?></textarea>                    
                </div>                
            </div>
            <div class="row mb-3 justify-content-center justify-content-sm-start">
                <label class="col-3 text-end col-form-label align-items-center" for="price"><?php echo ucfirst($page->language['price']); ?>:</label>
                <div class="col-3 col-sm-2 align-items-center">
                    <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php echo $dishe['price']; ?>" required>
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label" for="category"><?php echo ucfirst($page->language['category']); ?>:</label>
                <div class="col-12 col-sm-8 text-center text-sm-start">
                    <select name="category" id="category">
                        <option value="<?php echo $dishe['category_id']; ?>"><?php echo ucfirst($page->language[$dishe['category_name']]); ?></option>
                    <?php foreach ($categoriesDishesDay as $key => $category) { ?>
                        <option value="<?php echo $category["category_id"]; ?>"><?php echo ucfirst($page->language[$category["category_name"]]); ?></option>
                    <?php } ?>
                    </select>                   
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label" for="dishes_type"><?php echo ucfirst($page->language['dish_type']); ?>:</label>
                <div class="col-12 col-sm-8 text-center text-sm-start">
                    <select name="dishes_type" id="dishes_type">
                        <option value="<?php echo $disheType['menu_id']; ?>"><?php echo ucfirst($page->language[$disheType['menu_category']]); ?></option>
                    <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                        <option value="<?php echo $category["menu_id"]; ?>"><?php echo ucfirst($page->language[$category["menu_category"]]); ?></option>
                    <?php } ?>
                    </select>                   
                </div>                
            </div>
            <div class="row mb-3">
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label"><?php echo ucfirst($page->language['image']); ?>:</label>
                <div class="col-12 col-sm-5 text-center text-sm-start">
                    <a href="/menu/showDisheInfo/<?php echo $dishe['dishe_id']; ?>">
                        <img class="img-fluid w-50 bg-light" src="<?php echo $dishePicture; ?>" alt="dishe_image"> 
                    </a>                                    
                </div>                
            </div>
            <div class="row mb-3">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />  
                <label class="col-12 col-sm-3 text-center text-sm-end col-form-label pt-0" for="dishe_img"><?php echo ucfirst($page->language['change_image']); ?>:</label>
                <div class="col-12 col-sm-8 input-group inputFile">
                    <input type="file" id="dishe_img" name="dishe_img" />
                </div>                
            </div>
            <div class="row mb-3 justify-content-center justify-content-sm-start">
                <label class="col-3 text-end form-check-label pt-0" for="available"><?php echo ucfirst($page->language['available']); ?>:</label>
                <div class=" col-2 text-sm-start d-flex">
                    <?php if($dishe['available'] === 'si') {?>
                        <input class="form-check-input align-self-center m-0" type="checkbox" name="available" id="available" value="no" checked> 
                    <?php }else { ?>                    
                        <input class="form-check-input align-self-center m-0" type="checkbox" name="available" id="available" value="si"> 
                    <?php } ?>
                </div>                
            </div>
                          
            <div class="row mb-3">
                <label class="col-12 col-md-3 text-center text-md-end">&nbsp;</label>
                <div class="col-12 col-md-8 text-center">                   
                    <button class="btn btn-outline-success" type="submit" name="action" value="update"><?php echo ucfirst($page->language['update']); ?></button>                                       
                    <a class="btn btn-outline-success" href="/admin/dishes/index"><?php echo ucfirst($page->language['go_back']); ?></a>
                </div>                
            </div>                                                              
        </form>        
    </div>    
<?php
	$page->do_html_footer();
?>