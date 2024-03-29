<form action="/admin/dishes/new" method="post" enctype="multipart/form-data">
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="name"><?php echo ucfirst($home->language['name']); ?>:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="name" id="name" value="<?php if(isset($fields)) echo $fields['Name']; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="description"><?php echo ucfirst($home->language['description']); ?>:</label>
        <div class="col-sm-8">
            <textarea class="form-control" name="description" id="description" cols="30" rows="10" required><?php if(isset($fields)) echo $fields['Description']; ?></textarea>                    
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="price"><?php echo ucfirst($home->language['price']); ?>:</label>
        <div class="col-sm-2">
            <input class="form-control" type="number" step="0.01" min="0" max="5000" name="price" id="price" value="<?php if(isset($fields)) echo $fields['Price']; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="category"><?php echo ucfirst($home->language['category']); ?>:</label>
        <div class="col-12 col-md-8 text-center text-md-start">
            <select name="category" id="category" required>
                <option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
            <?php foreach ($categoriesDishesDay as $key => $category) { ?>
                <option value="<?php echo $category["category_id"]; ?>"><?php if(isset($category)) echo ucfirst($home->language[$category["category_name"]]); ?></option>
            <?php } ?>
            </select>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="dishes_type"><?php echo ucfirst($home->language['dish_type']); ?>:</label>
        <div class="col-12 col-md-8 text-center text-md-start">
            <select name="dishes_type" id="dishes_type" required>
                <option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
            <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                <option value="<?php echo $category["menu_id"]; ?>"><?php if(isset($category)) echo ucfirst($home->language[$category["menu_category"]]); ?></option>
            <?php } ?>
            </select>
        </div>                
    </div> 
    <div class="row mb-3">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />  
        <label class="col-12 col-md-3 text-center text-md-end col-form-label" for="dishe_img"><?php echo ucfirst($home->language['image']); ?>:</label>
        <div class="col-12 col-md-8 input-group inputFile">
            <input type="file" id="dishe_img" name="dishe_img" />
        </div>                
    </div>                    
    <div class="row mb-3">
        <label class="col-12 col-md-3 text-center text-md-end">&nbsp;</label>
        <div class="col-12 col-md-8 text-center text-sm-start">
            <button class="btn btn-outline-success" type="submit" name="action" value="new"><?php echo ucfirst($home->language['send']); ?></button>                 
        </div>                
    </div>                                                              
</form>
