<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "menu");
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-4">
		<div class="col mb-3 <?php echo $category; ?>"></div>
		<div class="row mb-3">
			<div class="col-12 col-md-3 col-lg-2 col-xl-1 d-flex justify-content-center align-items-center">
				<figure class="figure">							
						<a href="/menu/menu" target="_blank"><img class="figure-img img-fluid mainLogo" src="/images/menu.png" alt="menu_image"></a>
						<figcaption class="figure-caption text-center"><?php echo ucfirst($home->language['nav_link_menu']); ?></figcaption>
				</figure>
			</div>
			<div class="col-12 col-md-6 col-lg-10 col-xl-11 d-flex justify-content-center align-items-center">
				<h2 class="m-0 me-3"><?php echo ucwords($home->language[$category]); ?></h2>	
			</div>
		</div>		
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4 col-lg-3">
				<ul class="ps-0">
			<?php echo $showResult; ?>					
		</div>
		<div class="row">
			<form class="mb-3 text-center text-lg-start" action="/menu" method="post"><button class="btn btn-primary" type="submit" name="action" value="index"><?php echo ucfirst($home->language['go_back']) ?></button></form>
		</div>				
	</section>

								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>
