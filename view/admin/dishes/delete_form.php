<form class="d-inline" action="#" method="post" onsubmit="return confirm('¿Estás seguro de querer eliminar el registro?')">
    <input type="hidden" name="dishe_id" value="<?php echo $value['dishe_id']; ?>">
    <button type="submit" class="btn btn-outline-danger w-45" name="action" value="delete"><?php echo ucfirst($page->language['delete']); ?></button>
</form>