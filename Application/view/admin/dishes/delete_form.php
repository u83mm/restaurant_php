<form class="d-inline" action="/admin/dishes/delete" method="post" onsubmit="return confirm('¿<?php echo ucfirst($page->language['alert_delete']); ?>?')">
    <input type="hidden" name="dishe_id" value="<?php echo $value['dishe_id']; ?>">
    <button type="submit" class="btn btn-outline-danger w-45" name="action" value="delete"><?php echo ucfirst($page->language['delete']); ?></button>
</form>