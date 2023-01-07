<?php	
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Inicio";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->menus);
?>	
	<section class="col-9 pe-3">
		<div class="col mb-3 mainImg">
			
		</div>
		<div class="col d-flex justify-content-center align-items-center mb-3">
			<h2 class="m-0 me-2">Bienvenido!!</h2>
			<img class="img-fluid mainLogo" src="images/restaurant_logo.png" alt="logo">
		</div>		
		<div class="clear-fix">
			<img class="w-25 float-start me-3" src="images/home-img1.jpg" alt="home-img1">
			<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio ipsam ipsa molestias maxime! Iusto ipsa iste inventore ut rem adipisci, nihil mollitia voluptas pariatur eius ratione ducimus assumenda corporis. Porro voluptas debitis animi aliquam ea, iusto officia sed quas dolorem voluptatem fugiat sunt minus ipsa eligendi repudiandae tenetur, fuga a?</p>
			<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut, ea alias. Delectus id saepe hic sapiente sit reprehenderit iste unde vitae neque distinctio illum temporibus suscipit ipsum sequi harum corrupti ipsa, libero nesciunt accusamus nam aliquam explicabo! Quos tenetur non similique optio excepturi, dolore accusamus nisi ea. Omnis laborum corporis animi in accusamus a adipisci. Delectus perspiciatis iusto molestias odio similique atque laudantium totam officia dolorum, earum, rerum laborum dolore quod dolorem! Fuga recusandae incidunt ducimus, repudiandae quisquam aperiam, itaque reiciendis rem quidem fugiat debitis, eaque odit ipsa. Eaque itaque officiis nulla quibusdam. Ipsam praesentium aperiam nemo magnam debitis assumenda!</p>
			<img class="w-25 float-end ms-3" src="images/home-img2.jpg" alt="home-img2">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus illum ab deserunt excepturi quasi molestiae esse, temporibus eligendi, eveniet illo facere error, repudiandae id architecto a omnis natus reiciendis corporis dolorum laborum ut eaque facilis. Vero, sit quam ipsum, optio dignissimos consequatur tempore voluptatibus laboriosam, beatae cum fugit accusantium quisquam rerum. Saepe reiciendis est magni quidem, esse eos nisi pariatur dicta commodi minus blanditiis voluptatibus culpa optio eaque ad quisquam non ipsam aut veniam ipsa.</p>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic alias, fuga eaque ex vero maiores, illum deserunt veritatis nobis excepturi quae praesentium expedita nisi a, quisquam consequatur eius perferendis eum obcaecati nemo necessitatibus aliquid. Quibusdam, cumque vitae tempore temporibus libero architecto velit officiis iure? Error, et, a architecto perspiciatis quod aperiam tempora iste ullam laudantium, harum fugit nobis voluptatem perferendis.</p>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut error voluptatem doloribus veniam dolore deleniti similique? Iure quod architecto odio in velit animi voluptas doloremque quos quae ad. Rem, quam? Libero magnam ut ex praesentium, ipsam recusandae? Soluta non quidem consectetur praesentium accusantium nesciunt nulla veniam aperiam quaerat sapiente, iste, officia similique nobis modi et ipsam, architecto libero reprehenderit labore nam tempore. Quaerat facilis, eaque natus ab harum dolor. Vel itaque incidunt repellendus explicabo alias a animi exercitationem optio assumenda!</p>
		</div>
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
