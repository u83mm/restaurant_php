<form id="categories-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
    <?php extract($fields); ?>
    <div class="mb-3">
        <label for="category" class="form-label col-md-3"><?php echo ucfirst($page->language['category']); ?>:</label>
        <div class="col-md-7 d-inline-block">
            <input type="text" class="form-control" id="category" name="category" value="<?php if(isset($category)) echo $page->language[$category]; ?>" required>
        </div>                
    </div>
    <div class="mb-3">
        <label for="dish_menu_menuEmoji" class="form-label col-md-3">Emoji:</label>
        <div class="col-md-7 d-inline-block">
            <input type="text" class="form-control" id="dish_menu_menuEmoji" name="emoji" value="<?php echo $emoji ?? '' ?>" readonly>
        </div>                
    </div>
    <div class="mb-3 d-md-flex">
        <label class="col col-md-3 align-self-baseline align-self-md-center mt-0 pt-0" for="none"><?php echo ucfirst($page->language['select_emoji']) ?>:</label>
        <div id="emoji-container" class="col col-md-7"></div>
    </div>
    <div class="mb-3">
        <label class="col-lg-3" for="none">&nbsp;</label>
        <div class="col-lg-7 d-inline-block">
            <button type="submit" class="btn btn-outline-primary mt-0"><?php echo ucfirst($page->language['save']); ?></button>
            <a class="btn btn-outline-primary mb-5" href="/admin/categories/index"><?php echo ucfirst($page->language['go_back']); ?></a>
        </div>                
    </div>
</form>