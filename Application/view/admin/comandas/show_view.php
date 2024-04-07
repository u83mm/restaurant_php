<?php
	declare(strict_types=1);
		
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['orders']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>	
												<!-- SECTION WITH INFO -->
									
	<section class="col-12 p-sm-0 pe-lg-3">		
		<div class="col d-flex justify-content-center align-items-center mb-5">
			<h2 class="m-0 me-2"><?php echo ucfirst($home->language['orders']); ?></h2>			
		</div>

		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : $this->message; ?>
			</div>
		</div>
		<div class="row d-flex justify-content-evenly">			
			<?php foreach ($row as $key_order => $order): ?>
                <div class="col-12 col-md-6 col-xl-4 mb-5">
				<div class="w-100 menuDia">
					<form id="show_order_form" action="/admin/comandas/add" method="post">							

													<!-- Mesa y personas -->

						<div class="col text-center">
							<h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['table']); ?>:</strong> <?php echo $order['table_number']; ?></h4>
							<h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['people']) ?>:</strong> <?php echo $order['people_qty']; ?></h4>
						</div>				
						<hr>

														<!-- Aperitivos -->

						<div class="col">
							<?php if (!empty($order['aperitifs'][$key_order][0])): ?>	
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['aperitivos']); ?></strong></h4>
							<ul>					
							<?php foreach ($order['aperitifs'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="aperitifs_name[]" id="aperitifs_name" value="<?php echo $value; ?>">
										<input type="hidden" name="aperitifs_finished[]" id="aperitifs_finished" class="item_finished" value="<?php echo $order['aperitifs_finished'][$key_order][$key]; ?>">										
										<div id="aperitifs_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>
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
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['firsts']); ?></strong></h4>
							<ul>
							<?php foreach ($order['firsts'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="firsts_name[]" id="firsts_name" value="<?php echo $value; ?>">
										<input type="hidden" name="firsts_finished[]" id="firsts_finished" class="item_finished" value="<?php echo $order['firsts_finished'][$key_order][$key]; ?>">										
										<div id="firsts_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>
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
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['seconds']); ?></strong></h4>
							<ul>
							<?php foreach ($order['seconds'][$key_order] as $key => $value): ?>
													
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="seconds_name[]" id="seconds_name" value="<?php echo $value; ?>">
										<input type="hidden" name="seconds_finished[]" id="seconds_finished" class="item_finished" value="<?php echo $order['seconds_finished'][$key_order][$key]; ?>">										
										<div id="seconds_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>
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
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['desserts']); ?></strong></h4>
							<ul>
							<?php foreach ($order['desserts'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="desserts_name[]" id="desserts_name" value="<?php echo $value; ?>">
										<input type="hidden" name="desserts_finished[]" id="desserts_finished" class="item_finished" value="<?php echo $order['desserts_finished'][$key_order][$key]; ?>">										
										<div id="desserts_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>
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
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['drinks']); ?></strong></h4>
							<ul>
							<?php foreach ($order['drinks'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="drinks_name[]" id="drinks_name" value="<?php echo $value; ?>">
										<input type="hidden" name="drinks_finished[]" id="drinks_finished" class="item_finished" value="<?php echo $order['drinks_finished'][$key_order][$key]; ?>">										
										<div id="drinks_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>
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
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['coffees_and_liquors']); ?></strong></h4>
							<ul>
							<?php foreach ($order['coffees'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="coffees_name[]" id="coffees_name" value="<?php echo $value; ?>">
										<input type="hidden" name="coffees_finished[]" id="coffees_finished" class="item_finished" value="<?php echo $order['coffees_finished'][$key_order][$key]; ?>">										
										<div id="coffees_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($home->language[strtolower($value)]); ?>
										</div>										
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
							<input type="hidden" name="table_number" value="<?php echo $order['table_number']; ?>"> 
							<input type="hidden" name="people_qty" value="<?php echo $order['people_qty'] ?>">         						
							<!-- <button class="btn btn-outline-primary" type="submit" name="action" value="update_comanda"><?php //echo ucfirst($home->language['update']); ?></button> -->
							<button type="button" id="update_button" class="btn btn-outline-primary" value="/admin/comandas/update"><?php echo ucfirst($home->language['update']); ?></button>
							<button class="btn btn-outline-success" type="submit" name="action" value="add"><?php echo ucfirst($home->language['add']); ?></button>	                            
							<a class="btn btn-outline-success" href="/admin/comandas/index"><?php echo ucfirst($home->language['go_back']); ?></a>
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