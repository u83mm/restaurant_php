<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>	
								<!-- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-3">
		<div class="col mb-3 <?php echo $dishe['menu_category']; ?>"></div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center align-items-center mb-3">
				<h2 class="m-0 me-2"><?php echo ucfirst($dishe['name']); ?></h2>
				<img class="img-fluid mainLogo" src="/images/restaurant_logo.png" alt="logo">
			</div>
		</div>		
		<div class="row">
            <div class="clear-fix">
                <img class="float-start me-3" src="<?php echo $dishe_picture ; ?>" alt="dishe-image">                
                <?php echo $description; ?>
            </div>		
		</div>
		<div class="row">
			<div class="col-3"></div>
			<div class="col-9 p-4">
				<h3>Precio: <?php echo number_format($dishe['price'], 2, ",", ".") ; ?>€</h3>
			</div>			
		</div>
		<div class="row">
			<form class="mb-3 text-center text-lg-start" action="/menu/menu.php" method="post">
				<button type="submit" name="action" value="<?php echo $dishe['menu_category']; ?>">Volver atrás</button>
			<?php if(isset($_SESSION['user_name'])) { ?>
				<button class="btn btn-outline-success">Pedir</button>
			<?php } ?>
			</form>			
		</div>			
	</section>
								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>
