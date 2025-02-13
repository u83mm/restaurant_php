<form class="d-inline" action="/admin/categories/delete" method="post" onsubmit="return confirm('¿<?php echo ucfirst($page->language['alert_delete']); ?>?')">
    <input type="hidden" name="id" value="<?php echo $category['menu_id']; ?>">
    <button type="submit" class="btn btn-outline-danger"><?php echo ucfirst($page->language['delete']); ?></button>
</form>