<form action="#" method="post" enctype="multipart/form-data">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="name">Nombre:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="name" id="name" value="<?php if(isset($category)) echo $name; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="description">Descripción:</label>
        <div class="col-sm-8">
            <textarea class="form-control"name="description" id="description" cols="30" rows="10" required><?php if(isset($category)) echo $description; ?></textarea>                    
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="category">Categoría:</label>
        <div class="col-sm-8">
            <select name="category" id="category">
                <option value="">- Selecciona -</option>
            <?php foreach ($categoriesDishesDay as $key => $category) { ?>
                <option value="<?php echo $category["category_id"]; ?>"><?php if(isset($category)) echo $category["category_name"]; ?></option>
            <?php } ?>
            </select>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="dishes_type">Tipo de Plato:</label>
        <div class="col-sm-8">
            <select name="dishes_type" id="dishes_type">
                <option value="">- Selecciona -</option>
            <?php foreach ($categoriesDishesMenu as $key => $category) { ?>
                <option value="<?php echo $category["menu_id"]; ?>"><?php if(isset($category)) echo $category["menu_category"]; ?></option>
            <?php } ?>
            </select>
        </div>                
    </div> 
    <div class="row mb-3">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />  
        <label class="col-sm-3 col-form-label" for="dishe_img">Imagen:</label>
        <div class="col-sm-8">
            <input type="file" id="dishe_img" name="dishe_img"  />
        </div>                
    </div>                    
    <div class="row mb-3">
        <label class="col-sm-3" for="nome">&nbsp;</label>
        <div class="col-sm-8">
            <input type="submit" name="action" value="New">        
        </div>                
    </div>                                                              
</form>