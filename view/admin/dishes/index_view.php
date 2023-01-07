<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Platos";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->menus);
?>
	<h4 class="text-center">LISTADO DE PLATOS</h4>
    <div class="col mx-auto">
        <?php echo $message = $error_msg ?? $success_msg ?? ""; ?>
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
        <div class="row">
            <form action="#" method="post">
                <input type="submit" class="btn btn-primary mb-5" name="action" value="New">                
                <a class="btn btn-primary mb-5" href="/admin/admin.php">Volver</a>
            </form>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>