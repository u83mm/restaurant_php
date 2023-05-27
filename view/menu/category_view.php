<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "menu");
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-3">
		<div class="col mb-3 <?php echo $category; ?>"></div>
		<div class="row mb-3">
			<div class="col-12 col-md-3 col-lg-2 col-xl-1 d-flex justify-content-center align-items-center">
				<figure class="figure">							
						<a href="/menu/menu.php?action=menu_pdf" target="_blank"><img class="figure-img img-fluid mainLogo" src="/images/menu.png" alt="menu_image"></a>
						<figcaption class="figure-caption text-center">Carta</figcaption>
				</figure>
			</div>
			<div class="col-12 col-md-6 col-lg-10 col-xl-11 d-flex justify-content-center align-items-center">
				<h2 class="m-0 me-3"><?php echo ucfirst($category); ?></h2>	
			</div>
		</div>		
		<div class="row">
			<div class="col-12 col-md-4 col-lg-3">
				<ul>
			<?php echo $showResult; ?>					
		</div>
		<div class="row">
			<form class="mb-3 text-center text-lg-start" action="/menu/menu.php" method="post"><button class="btn btn-primary" type="submit" name="action" value="index">Volver atrás</button></form>
		</div>				
	</section>

								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>
