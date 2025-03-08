<?php
declare(strict_types=1);

use Application\model\classes\PageClass;

$page = new PageClass();
$page->title = "My Restaurant | Categories";

$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
$page->do_html_nav($page->nav_links, $page->language['nav_link_administration']);
?>
<h3 class="text-center"><?php echo mb_strtoupper($page->language['categories']); ?></h3>
<?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-9 mx-auto table-responsive">
            <table class="col-12">
                <thead class="text-center">
                    <tr>
                        <th>Id</th>
                        <th><?php echo ucfirst($page->language['category']); ?></th>
                        <th>Emoji</th>
                        <th><?php echo ucfirst($page->language['options']); ?></th>                                                
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ; ?>                    
                    <tr>
                        <td class="text-center"><?php echo $category['menu_id']; ?></td>
                        <td><?php if(isset($category["{$_SESSION['language']}_menu_category"])) echo ucfirst($category["{$_SESSION['language']}_menu_category"]); ?></td>
                        <td class="text-center"><?php echo $category['menu_emoji'] ?></td>
                        <td class="text-center options">
                            <a class="btn btn-outline-success" href="/admin/categories/edit/<?php echo $category['menu_id']; ?>"><?php echo ucfirst($page->language['edit']); ?></a>
                            <?php include(SITE_ROOT . '/../Application/view/admin/categories/delete_form.php'); ?>
                        </td>                        
                    </tr>
                    <?php endforeach; ?>                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-center">
                            <a class="btn btn-outline-primary" href="/admin/categories/new"><?php echo ucfirst($page->language['new_category']) ?></a>
                            <a class="btn btn-outline-primary" href="/admin/admin/adminMenus"><?php echo ucfirst($page->language['go_back']); ?></a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php
$page->do_html_footer();
?>