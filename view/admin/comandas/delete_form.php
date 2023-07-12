<form class="d-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return confirm('¿<?php echo ucfirst($home->language['alert_delete']); ?>?')">
    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
    <button class="btn btn-outline-danger" type="submit" name="action" value="delete"><?php echo ucfirst($home->language['delete']); ?></button> 
</form>