<?php	
	use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My restaurant | ". ucfirst($page->language['users']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "administration");
?>
	<h3 class="text-center"><?php echo strtoupper($page->language['user_list']); ?></h3>
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
                                <form action="/admin/admin/show" method="post" class="d-inline">
                                    <!-- <input type="hidden" name="id_user" value="<?php //echo $value['id']; ?>"> -->                                                                           
                                    <a class="btn btn-outline-success" href="/admin/admin/show/<?php echo $value['id']; ?>"><?php echo ucfirst($page->language['edit']); ?></a>
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
            <form class="text-center text-lg-start" action="/admin/admin/new" method="post">
                <button class="btn btn-primary mb-5" type="submit" name="action" value="new"><?php echo ucfirst($page->language['new']); ?></button>                                
                <a class="btn btn-primary mb-5" href="/admin/admin/adminMenus"><?php echo ucfirst($page->language['go_back']); ?></a>
            </form>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>