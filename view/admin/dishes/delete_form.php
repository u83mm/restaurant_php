<form class="d-inline" action="#" method="post" onsubmit="return confirm('¿Estás seguro de querer eliminar el registro?')">
    <input type="hidden" name="dishe_id" value="<?php echo $value['dishe_id']; ?>">
    <input type="submit" class="btn btn-outline-danger" name="action" value="Delete">
</form>