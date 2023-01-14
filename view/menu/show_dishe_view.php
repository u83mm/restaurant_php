<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-9 pe-3">
		<div class="col mb-3 mainImg"></div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center align-items-center mb-3">
				<h2 class="m-0 me-2"><?php echo $dishe['name']; ?></h2>
				<img class="img-fluid mainLogo" src="/images/restaurant_logo.png" alt="logo">
			</div>
		</div>		
		<div class="row">
            <div class="clear-fix">
                <img class="w-25 float-start me-3" src="<?php echo $dishe_picture ; ?>" alt="dishe-image">
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio ipsam ipsa molestias maxime! Iusto ipsa iste inventore ut rem adipisci, nihil mollitia voluptas pariatur eius ratione ducimus assumenda corporis. Porro voluptas debitis animi aliquam ea, iusto officia sed quas dolorem voluptatem fugiat sunt minus ipsa eligendi repudiandae tenetur, fuga a?</p>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut, ea alias. Delectus id saepe hic sapiente sit reprehenderit iste unde vitae neque distinctio illum temporibus suscipit ipsum sequi harum corrupti ipsa, libero nesciunt accusamus nam aliquam explicabo! Quos tenetur non similique optio excepturi, dolore accusamus nisi ea. Omnis laborum corporis animi in accusamus a adipisci. Delectus perspiciatis iusto molestias odio similique atque laudantium totam officia dolorum, earum, rerum laborum dolore quod dolorem! Fuga recusandae incidunt ducimus, repudiandae quisquam aperiam, itaque reiciendis rem quidem fugiat debitis, eaque odit ipsa. Eaque itaque officiis nulla quibusdam. Ipsam praesentium aperiam nemo magnam debitis assumenda!</p>               
            </div>		
		</div>				
	</section>
								<!--- ASIDE SHOWING MENU'S DAY -->
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
