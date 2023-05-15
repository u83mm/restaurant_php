<?php
	declare(strict_types=1);
		
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Comandas";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links);
?>	
												<!-- SECTION WITH INFO -->
									
	<section class="col-12 p-sm-0 pe-lg-3">		
		<div class="col d-flex justify-content-center align-items-center mb-5">
			<h2 class="m-0 me-2">Comandas</h2>			
		</div>

		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<?php echo $this->message; ?>
			</div>
		</div>
		<div class="row justify-content-evenly">			
			<?php foreach ($rows as $key_order => $order): ?>														
			<div class="col-12 col-md-6 col-xl-4 mb-5">
				<div class="w-100 menuDia">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">							

													<!-- Mesa y personas -->

						<div class="col text-center">
							<h4 class="col-5 d-inline-block"><strong>MESA:</strong> <?php echo $order['table_number'] ?></h4>
							<h4 class="col-5 d-inline-block"><strong>PERSONAS:</strong> <?php echo $order['people_qty'] ?></h4>
						</div>				
						<hr>

														<!-- Aperitivos -->

						<div class="col">
							<?php if (!empty($order['aperitifs'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>APERITIVOS</strong></h4>
							<ul>					
							<?php foreach ($order['aperitifs'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="aperitifs_name[]" id="aperitifs_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="aperitifs_qty[]" id="aperitifs_qty" value="<?php echo $order['aperitifs_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<?php endif ?>				
						</div>
						
														<!-- Primeros -->

						<div class="col">
							<?php if (!empty($order['firsts'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>PRIMEROS</strong></h4>
							<ul>
							<?php foreach ($order['firsts'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="firsts_name[]" id="firsts_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="firsts_qty[]" id="firsts_qty" value="<?php echo $order['firsts_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<?php endif ?>				
						</div>
						
														<!-- Segundos -->

						<div class="col">
							<?php if (!empty($order['seconds'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>SEGUNDOS</strong></h4>
							<ul>
							<?php foreach ($order['seconds'][$key_order] as $key => $value): ?>
													
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="seconds_name[]" id="seconds_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="seconds_qty[]" id="seconds_qty" value="<?php echo $order['seconds_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>						
							<?php endforeach ?>
							</ul>
							<?php endif ?>				
						</div>
						
														<!-- Postres -->

						<div class="col">
							<?php if (!empty($order['desserts'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>POSTRES</strong></h4>
							<ul>
							<?php foreach ($order['desserts'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="desserts_name[]" id="desserts_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="desserts_qty[]" id="desserts_qty" value="<?php echo $order['desserts_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>	
							<?php endif ?>			
						</div>

														<!-- Bebidas -->

						<div class="col">
							<?php if (!empty($order['drinks'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>BEBIDAS</strong></h4>
							<ul>
							<?php foreach ($order['drinks'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="drinks_name[]" id="drinks_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="drinks_qty[]" id="drinks_qty" value="<?php echo $order['drinks_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>	
							<?php endif ?>			
						</div>

														<!-- Cafés y licores -->

						<div class="col">
							<?php if (!empty($order['coffees'][$key_order][0])): ?>	
							<h4 class="text-center"><strong>CAFÉS Y LICORES</strong></h4>
							<ul>
							<?php foreach ($order['coffees'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="coffees_name[]" id="coffees_name" value="<?php echo $value; ?>">
										<?php echo $value; ?>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="coffees_qty[]" id="coffees_qty" value="<?php echo $order['coffees_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<?php endif ?>				
						</div>
						<div class="col-12 text-center">
							<input type="hidden" name="id" value="<?php echo $order['id']; ?>">           						
							<button class="btn btn-outline-primary" type="submit" name="action" value="update_order">Actualizar</button>
							<button class="btn btn-outline-success" type="submit" name="action" value="add">Añadir</button>						
						</div>
					</form>
					<?php include("delete_form.php") ?>
				</div>
			</div>							
			<?php endforeach ?>
		</div>				
	</section>			
<?php
	$home->do_html_footer();
?>