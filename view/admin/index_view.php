<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | Usuarios";

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "administration");
?>
	<h3 class="text-center">LISTADO DE USUARIOS</h3>
    <div class="col mx-auto">
        <div class="col-12 col-md-6 mx-auto">
            <?php echo $message = $message ?? ""; ?>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th>User Name</th>                        
                            <th>Email</th>
                            <th>Role</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $value) { ?>
                        <tr>
                            <td><?php echo $value['id']; ?></td>
                            <td><?php echo $value['user_name']; ?></td>                        
                            <td><?php echo $value['email']; ?></td>
                            <td><?php echo $value['role']; ?></td>
                            <td class="text-center">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="d-inline">
                                    <input type="hidden" name="id_user" value="<?php echo $value['id']; ?>">
                                    <button class="btn btn-outline-success" type="submit" name="action" value="show"><?php echo ucfirst($page->language['edit']); ?></button>
                                </form>
                                <?php include(SITE_ROOT . "/../view/admin/user_delete_form.php"); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>            
        </div>
        <div class="row">
            <form class="text-center text-lg-start" action="#" method="post">
                <button class="btn btn-primary mb-5" type="submit" name="action" value="new"><?php echo ucfirst($page->language['new']); ?></button>                                
                <a class="btn btn-primary mb-5" href="/admin/admin.php"><?php echo ucfirst($page->language['go_back']); ?></a>
            </form>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>