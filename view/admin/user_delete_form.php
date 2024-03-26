<form class="d-inline" action="/admin/admin/delete" method="post" onsubmit="return confirm('¿<?php echo ucfirst($page->language['alert_delete']); ?>?')">
    <input type="hidden" name="id_user" value="<?php echo $value['id']; ?>">
    <button type="submit" class="btn btn-outline-danger" name="action" value="delete"><?php echo ucfirst($page->language['delete']); ?></button>
</form>