<?php

    use model\classes\CommonTasks;
    use model\classes\PageClass;

	$page = new PageClass();
    $page->title = "My Restaurant | " . ucfirst($page->language['dishes']);

	$page->do_html_header($page->title, $page->h1, $page->meta_name_description, $page->meta_name_keywords);
	$page->do_html_nav($page->nav_links, "administration");
?>
	<h4 class="text-center"><?php echo strtoupper($page->language['product_list']); ?></h4>
    <div class="container-fluid">        
        <div class="row">
            <div class="col-12 col-xl-9 mx-auto table-responsive">
            <?php echo $message = $_SESSION['message'] ?? $this->message ?? ""; ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th><?php echo ucfirst($page->language['image']); ?></th>
                            <th><?php echo ucfirst($page->language['name']); ?></th>                                                
                            <th><?php echo ucfirst($page->language['day_menu']); ?></th>
                            <th><?php echo ucfirst($page->language['category']); ?></th>
                            <th><?php echo ucfirst($page->language['available']); ?></th>
                            <th class="options"><?php echo ucfirst($page->language['options']); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($rows)) foreach ($rows as $value) { ?>
                        <tr>
                            <td><?php echo $value['dishe_id']; ?></td>                            
                            <td class="align-middle col-1">                                                               
                                <a href="/menu/showDisheInfo/<?php echo $value['dishe_id']; ?>"><img class="img-fluid" src="<?php echo $commonTask->getWebPath($value['picture']); ?>" alt="img_dishe"></a>
                            </td>
                            <td><?php echo ucfirst($page->language[$value['name']]); ?></td>                                                
                            <td><?php echo ucfirst($page->language[$value['category_name']]); ?></td>
                            <td><?php echo ucfirst($page->language[$value['menu_category']]); ?></td>
                            <?php if($value['available'] === 'si'): ?>
                                <td class="text-center">&#9989;</td>
                            <?php else: ?>
                                <td class="text-center">&#10060;</td>
                            <?php endif ?>                            
                            <td class="text-center">
                                <a class="btn btn-outline-success w-45" href="/admin/dishes/edit/<?php echo $value['dishe_id']; ?>"><?php echo ucfirst($page->language['edit']); ?></a>
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
                    <form action="<?php PATH ?>" method="POST">
                        <input type="hidden" name="s" value="<?php echo $desde - $pagerows; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">
                        <!-- <input class="page-link" type="submit" value="Ant."> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>"><?php echo ucfirst($page->language['prev']); ?></button>
                    </form>                    
                </li>
				<li class="page-item">
                     <form action="<?php PATH ?>" method="POST">
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

			$pagination = new CommonTasks();
			$pagination->pagination1($pagina, $pagerows, $current_page, $action, $field);

			if($current_page != $pagina) {
?>
				<li class="page-item">
                    <form action="<?php PATH ?>" method="POST">
                        <input type="hidden" name="s" value="<?php echo $last; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">
                        <!-- <input class="page-link" type="submit" value=">>"> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>">>></button>
                    </form>                   
                </li>
				<li class="page-item">
                    <form action="<?php PATH ?>" method="POST">
                        <input type="hidden" name="s" value="<?php echo $desde + $pagerows; ?>">
                        <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                        <input type="hidden" name="field" value="<?php echo $field; ?>">
                        <input type="hidden" name="critery" value="<?php echo $critery; ?>">                           
                        <!-- <input class="page-link" type="submit" value="Sig."> -->
                        <button class="page-link" type="submit" name="action" value="<?php echo $action; ?>"><?php echo ucfirst($page->language['next']); ?></button>
                    </form>                    
                </li>				
<?php
			}			
		}
?>		
                </ul>
            </nav>
        </div>
                                         <!-- BOTONES DE CONTROL -->
        <div class="row mb-5">
            <div class="text-center text-lg-start">
                <a class="btn btn-primary" href="/admin/dishes/showForm"><?php echo ucfirst($page->language['new']); ?></a>                                              
                <a class="btn btn-primary" href="/admin/dishes/index"><?php echo ucfirst($page->language['go_to_list']); ?></a>                
                <a class="btn btn-primary" href="/admin/dishes/search"><?php echo ucfirst($page->language['search']); ?></a>
            </div>           
        </div>        
    </div>    
<?php
	$page->do_html_footer();
?>