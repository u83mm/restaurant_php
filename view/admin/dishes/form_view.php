<form action="#" method="post">
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="name">Nombre:</label>
        <div class="col-sm-8">
            <input class="form-control" type="text" name="name" id="name" value="<?php echo $name; ?>" required>
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="description">Descripción:</label>
        <div class="col-sm-8">
            <textarea class="form-control"name="description" id="description" cols="30" rows="10" required><?php echo $description; ?></textarea>                    
        </div>                
    </div>
    <div class="row mb-3">
        <label class="col-sm-2  col-form-label" for="category">Categoría:</label>
        <div class="col-sm-8">
            <select name="category" id="category">
                <option value="">- Selecciona -</option>
            <?php foreach ($categories as $key => $category) { ?>
                <option value="<?php echo $category["category_id"]; ?>"><?php echo $category["category_name"]; ?></option>
            <?php } ?>
            </select>
        </div>                
    </div>                  
    <div class="row mb-3">
        <label class="col-sm-2" for="nome">&nbsp;</label>
        <div class="col-sm-8">
            <input type="submit" name="action" value="New">        
        </div>                
    </div>                                                              
</form>