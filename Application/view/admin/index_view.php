<?php	
	use Application\model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My restaurant | ". ucfirst($page->language['users']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
	<h4 class="text-center"><?php echo strtoupper($page->language['user_list']); ?></h4>
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12 col-xl-9 mx-auto table-responsive">
                <div class="col-12 col-md-6 mx-auto">
                    <?php echo $message ?? ""; ?>
                </div>
                <table class="col-12">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th>User Name</th>                        
                            <th>Email</th>
                            <th>Role</th>
                            <th class="options">Options</th>
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
                                    <a class="btn btn-outline-success" href="/admin/admin/show/<?php echo $value['id']; ?>"><?php echo ucfirst($page->language['edit']); ?></a>
                                </form>
                                <?php include(SITE_ROOT . "/../Application/view/admin/user_delete_form.php"); ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>            
        </div>
        <div class="row">            
            <div class="col-12 col-lg-8 mx-auto">
                <a class="btn btn-primary" href="/admin/admin/new"><?php echo ucfirst($page->language['new']); ?></a>
                <a class="btn btn-primary" href="/admin/admin/adminMenus"><?php echo ucfirst($page->language['go_back']); ?></a>
            </div>
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>