<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Comandas";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links);
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 p-sm-0 pe-lg-3">		
		<div class="col d-flex justify-content-center align-items-center mb-3">
			<h2 class="m-0 me-2">Comandas</h2>
			<img class="img-fluid mainLogo" src="/images/restaurant_logo.png" alt="logo">
		</div>				
	</section>			
<?php
	$home->do_html_footer();
?>