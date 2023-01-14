<?php

use model\classes\CommonTasks;
use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Platos";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h4 class="text-center">LISTADO DE PLATOS</h4>
    <div class="col">
        <?php echo $message = $message ?? ""; ?>
        <div class="row">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Nombre</th>                        
                        <th>Descripción</th>
                        <th>Menú Día</th>
                        <th>Categoría</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $value) { ?>
                    <tr>
                        <td><?php echo $value['dishe_id']; ?></td>
                        <td><?php echo $value['name']; ?></td>                        
                        <td><?php echo $value['description']; ?></td>
                        <td><?php echo $value['category_name']; ?></td>
                        <td><?php echo $value['menu_category']; ?></td>
                        <td class="text-center">
                            <form action="#" method="post" class="d-inline">
                                <input type="hidden" name="dishe_id" value="<?php echo $value['dishe_id']; ?>">
                                <input class="btn btn-outline-success" type="submit" name="action" value="Show">
                            </form>
                            <?php include(SITE_ROOT . "/../view/admin/dishes/delete_form.php"); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

                                        <!-- SECCIÓN PARA LA PAGINACIÓN -->

        <div class="row mb-4">
            <nav aria-label="Pagination user-data">
                <ul class="pagination justify-content-center">
<?php
		if($pagina > 1) {
			if($current_page != 1) {
?>
				<li class="page-item">
                    <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="<?php echo $desde - $pagerows; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input class="page-link" type="submit" value="Ant.">
                    </form>
                    <!---<a class="page-link" href="/admin/admin_dishes.php?s=<?php //echo $desde - $pagerows; ?>&p=<?php //echo $pagina; ?>">Ant.</a> -->
                </li>
				<li class="page-item">
                     <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="0">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input class="page-link" type="submit" value="<<">
                    </form>
                    <!---<a class="page-link" href="/admin/admin_dishes.php?s=0&p=<?php //echo $pagina; ?>"><<</a>-->
                </li>				
<?php
			}
			else {
?>
				<label for="none">&nbsp;</label>
<?php
			}

			$pagination = new CommonTasks();
			$pagination->pagination1($pagina, $pagerows, $current_page);

			if($current_page != $pagina) {
?>
				<li class="page-item">
                    <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="<?php echo $last; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input class="page-link" type="submit" value=">>">
                    </form>                   
                </li>
				<li class="page-item">
                    <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="<?php echo $desde + $pagerows; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input class="page-link" type="submit" value="Sig.">
                    </form>                    
                </li>				
<?php
			}
			else {
?>
				<label for="none">&nbsp;</label>
<?php
			}
		}
?>		
                </ul>
            </nav>
        </div>
        <div class="row">
            <form action="#" method="post">                
                <button type="submit" class="btn btn-primary mb-5" name="action" value="show form">Nuevo</button>               
                <a class="btn btn-primary mb-5" href="/admin/admin.php">Volver</a>
            </form>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>