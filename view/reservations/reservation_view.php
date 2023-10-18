<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['reservations']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['reservations']);
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-4">
		<div class="col mb-3 reservations"></div>
		<div class="col d-flex justify-content-center align-items-center mb-3">
			<h2 class="m-0 me-2"><?php echo ucfirst($home->language['reservations']); ?></h2>			
		</div>		
		<div class="clear-fix">
			<?php echo $message = $this->message ?? ""; ?>
			<?php include(SITE_ROOT . "/../view/reservations/reservation_form.php"); ?>
		</div>
	</section>
								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>
