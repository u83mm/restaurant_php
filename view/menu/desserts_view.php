<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>	
	<section class="col-9 pe-3">
		<div class="col mb-3 mainImg"></div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center align-items-center mb-3">
				<h2 class="m-0 me-2">Nuestros Postres</h2>
				<img class="img-fluid mainLogo" src="/images/restaurant_logo.png" alt="logo">
			</div>
		</div>		
		<div class="row">
			<div class="col-3">
				<ul>
			<?php echo $showResult; ?>					
		</div>				
	</section>

	<aside class="col-3 mb-3 menus">		
		<div class="row text-center mb-3">
			<div class="col d-flex justify-content-center align-items-center">
				<h3>Menú del día</h3>
				<img class="img-fluid" src="/images/menu_dia_logo.png" alt="menu-logo">
			</div>				
		</div>		
		<div class="row mb-3">
			<h4 class="text-center"><strong>PRIMEROS PLATOS</strong></h4>
			<ul class="ps-4">
				<?php foreach ($primeros as $key => $plato) { ?>
					<li><?php echo $plato['name']; ?></li>
				<?php } ?>
			</ul>
		</div>
		<div class="row mb-3">
			<h4 class="text-center"><strong>SEGUNDOS PLATOS</strong></h4>
			<ul class="ps-4">
				<?php foreach ($segundos as $key => $plato) { ?>
					<li><?php echo $plato['name']; ?></li>
				<?php } ?>
			</ul>
		</div>
		<div class="row mb-3">
			<h4 class="text-center"><strong>POSTRE</strong></h4>
			<ul class="ps-4">
				<?php foreach ($postres as $key => $postre) { ?>
					<li><?php echo $postre['name']; ?></li>
				<?php } ?>
			</ul>
		</div>
								
		<h4><strong>PRECIO</strong></h4>
	</aside>
<?php
	$home->do_html_footer();
?>
