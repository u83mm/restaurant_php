<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-3">
		<div class="col mb-3 mainImg"></div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center align-items-center mb-3">
				<h2 class="m-0 me-3">Nuestra Carta</h2>				
				<!--<form action="#" method="post">
					<input type="hidden" name="action" value="menu_pdf">
					<input type="image" class="img-fluid mainLogo" src="/images/menu.png" alt="menu_image">
				</form> -->
				<a href="/menu/menu.php?action=menu_pdf" target="_blank"><img class="img-fluid mainLogo" src="/images/menu.png" alt="menu_image"></a>
			</div>
		</div>		
		<div class="row">
			<div class="col-6 col-md-4 col-lg-3">
				<ul>
			<?php echo $showResult; ?>					
		</div>			
	</section>
								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>
