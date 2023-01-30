<?php

use model\classes\CommonTasks;
use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Platos";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h4 class="text-center">LISTADO DE PLATOS</h4>
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12 col-xl-9 mx-auto table-responsive">
            <?php echo $message = $message ?? ""; ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th></th>
                            <th>Nombre</th>                                                
                            <th>Menú Día</th>
                            <th>Categoría</th>
                            <th>Disponible</th>
                            <th class="options">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($rows)) foreach ($rows as $value) { ?>
                        <tr>
                            <td><?php echo $value['dishe_id']; ?></td>                            
                            <td class="align-middle col-1">                               
                                <form class="d-inline" action="/menu/info_dishe/show_info.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $value['dishe_id']; ?>">
                                    <input class="img-fluid" type="image" src="<?php echo $commonTask->getWebPath($value['picture']); ?>" alt="img_dishe">
                                </form>
                            </td>
                            <td><?php echo $value['name']; ?></td>                                                
                            <td><?php echo ucfirst($value['category_name']); ?></td>
                            <td><?php echo ucfirst($value['menu_category']); ?></td>
                            <td><?php echo $value['available']; ?></td>
                            <td class="text-center">
                                <form action="#" method="post" class="d-inline">
                                    <input type="hidden" name="dishe_id" value="<?php echo $value['dishe_id']; ?>">
                                    <input class="btn btn-outline-success w-45" type="submit" name="action" value="Edit">
                                </form>
                                <?php include(SITE_ROOT . "/../view/admin/dishes/delete_form.php"); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>            
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
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">
                        <!-- <input class="page-link" type="submit" value="Ant."> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>">Ant.</button>
                    </form>                    
                </li>
				<li class="page-item">
                     <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="0">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">
                        <!-- <input class="page-link" type="submit" value="<<"> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>"><<</button>
                    </form>                    
                </li>				
<?php
			}
			else {
?>
				<label for="none">&nbsp;</label>
<?php
			}

			$pagination = new CommonTasks();
			$pagination->pagination1($pagina, $pagerows, $current_page, $action, $field);

			if($current_page != $pagina) {
?>
				<li class="page-item">
                    <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="<?php echo $last; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">
                        <!-- <input class="page-link" type="submit" value=">>"> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>">>></button>
                    </form>                   
                </li>
				<li class="page-item">
                    <form action="/admin/admin_dishes.php" method="POST">
                        <input type="hidden" name="s" value="<?php echo $desde + $pagerows; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">                           
                        <!-- <input class="page-link" type="submit" value="Sig."> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>">Sig.</button>
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
                                         <!-- BOTONES DE CONTROL -->
        <div class="row">
            <form class="text-center text-lg-start" action="/admin/admin_dishes.php" method="post">                
                <button type="submit" class="btn btn-primary mb-5" name="action" value="show_form">Nuevo</button>                               
                <button type="submit" class="btn btn-primary mb-5" name="action" value="listado">Ir a listado</button> 
                <button type="submit" class="btn btn-primary mb-5" name="action" value="search">Buscar</button>               
            </form>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>