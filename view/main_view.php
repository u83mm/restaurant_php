<?php	
	use model\classes\PageClass;

	$home = new PageClass();			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>
	<section class="col-9">
		<h3 class="text-center">Bienvenido!!</h3>
	</section>
	<aside class="col-3 mb-3 menus">
		<div class="row text-center mb-3">
			<div class="col d-flex justify-content-center align-items-center">
				<h3>Menú del día</h3>
				<img class="img-fluid" src="images/menu_dia_logo.png" alt="menu-logo">
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
