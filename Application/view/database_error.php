<?php
	//Application\model\classes\Loader::init(__DIR__ . "/..");

	$page_error = new Application\model\classes\PageClass;	
	$page_error->title = "My Restaurant | Error";	
						
	$page_error->do_html_header($page_error->title, $page_error->h1, $page_error->meta_name_description, $page_error->meta_name_keywords);
	$page_error->do_html_nav($page_error->nav_links);		
		echo $message ?? "";
	$page_error->do_html_footer();
?>
