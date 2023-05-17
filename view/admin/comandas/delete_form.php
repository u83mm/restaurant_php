<form class="d-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return confirm('¿Estás seguro de querer eliminar el pedido?')">
    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
    <button class="btn btn-outline-danger" type="submit" name="action" value="delete">Eliminar</button> 
</form>