<?php
	declare(strict_types=1);
		
	use Application\model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['orders']);
	
	$active_nav_link = $_SESSION['role'] === 'ROLE_ADMIN' ? $home->language['nav_link_administration'] : $home->language['nav_link_orders_list'];

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $active_nav_link);
?>	
												<!-- SECTION WITH INFO -->
									
	<section class="col-12 p-sm-0 pe-lg-3">		
		

		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : $message; ?>
			</div>
		</div>
		<div class="row d-flex justify-content-evenly">			
			<?php foreach ($row as $key_order => $order): ?>				
                <div class="col-12 col-md-6 col-xl-4 mb-5">
				<h2 class="m-0 me-2 text-center mb-4"><?php echo ucfirst($home->language['table']); ?> <span><?php echo $order['table_number']; ?></span></h2>
				<div class="w-100 menuDia">
					<form id="show_order_form" action="/admin/comandas/add" method="post">							

													<!-- Mesa y personas -->

						<div class="col text-center">
							<h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['table']); ?>:</strong> <?php echo $order['table_number']; ?></h4>
							<h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['people']) ?>:</strong> <?php echo $order['people_qty']; ?></h4>
						</div>				
						<hr/>

														<!-- Aperitivos -->

						<div class="col">
							<?php if (!empty($order['aperitifs'][$key_order][0])): ?>	
							<h4 class="text-center"><strong><?php echo strtoupper($home->language['aperitivos']); ?></strong></h4>
							<ul>					
							<?php foreach ($order['aperitifs'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="aperitifs_id[]" id="aperitifs_id<?php echo $key; ?>" value="<?php if(isset($order['aperitifs_id'][$key_order][$key])) echo $order['aperitifs_id'][$key_order][$key]; ?>">
										<input type="hidden" name="aperitifs_name[]" id="aperitifs_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="aperitifs_finished[]" id="aperitifs_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['aperitifs_finished'][$key_order][$key])) echo $order['aperitifs_finished'][$key_order][$key]; ?>">										
										<div id="aperitifs_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="aperitifs_qty[]" id="aperitifs_qty<?php echo $key; ?>" value="<?php echo $order['aperitifs_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<hr/>
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
										<input type="hidden" name="firsts_id[]" id="firsts_id<?php echo $key; ?>" value="<?php if(isset($order['firsts_id'][$key_order][$key])) echo $order['firsts_id'][$key_order][$key]; ?>">
										<input type="hidden" name="firsts_name[]" id="firsts_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="firsts_finished[]" id="firsts_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['firsts_finished'][$key_order][$key])) echo $order['firsts_finished'][$key_order][$key]; ?>">										
										<div id="firsts_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="firsts_qty[]" id="firsts_qty<?php echo $key; ?>" value="<?php echo $order['firsts_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<hr/>
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
										<input type="hidden" name="seconds_id[]" id="seconds_id<?php echo $key; ?>" value="<?php if(isset($order['seconds_id'][$key_order][$key])) echo $order['seconds_id'][$key_order][$key]; ?>">
										<input type="hidden" name="seconds_name[]" id="seconds_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="seconds_finished[]" id="seconds_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['seconds_finished'][$key_order][$key])) echo $order['seconds_finished'][$key_order][$key]; ?>">																				
										<div id="seconds_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="seconds_qty[]" id="seconds_qty<?php echo $key; ?>" value="<?php echo $order['seconds_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>						
							<?php endforeach ?>
							</ul>
							<hr/>
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
										<input type="hidden" name="desserts_id[]" id="desserts_id<?php echo $key; ?>" value="<?php if(isset($order['desserts_id'][$key_order][$key])) echo $order['desserts_id'][$key_order][$key]; ?>">
										<input type="hidden" name="desserts_name[]" id="desserts_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="desserts_finished[]" id="desserts_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['desserts_finished'][$key_order][$key])) echo $order['desserts_finished'][$key_order][$key]; ?>">																				
										<div id="desserts_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="desserts_qty[]" id="desserts_qty<?php echo $key; ?>" value="<?php echo $order['desserts_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<hr/>
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
										<input type="hidden" name="drinks_id[]" id="drinks_id<?php echo $key; ?>" value="<?php if(isset($order['drinks_id'][$key_order][$key])) echo $order['drinks_id'][$key_order][$key]; ?>">
										<input type="hidden" name="drinks_name[]" id="drinks_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="drinks_finished[]" id="drinks_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['drinks_finished'][$key_order][$key])) echo $order['drinks_finished'][$key_order][$key]; ?>">																				
										<div id="drinks_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="drinks_qty[]" id="drinks_qty<?php echo $key; ?>" value="<?php echo $order['drinks_qty'][$key_order][$key]; ?>" min="0">
									</div>							
								</li>
							<?php endforeach ?>
							</ul>
							<hr/>
							<?php endif ?>										
						</div>						

														<!-- Cafés y licores -->

						<div class="col">
							<?php if (!empty($order['coffees'][$key_order][0])): ?>	
							<h4 class="text-center"><strong><?php echo mb_strtoupper($home->language['coffees_and_liquors']); ?></strong></h4>
							<ul>
							<?php foreach ($order['coffees'][$key_order] as $key => $value): ?>						
								<li>
									<div class="col-9 d-inline-block">
										<input type="hidden" name="coffees_id[]" id="coffees_id<?php echo $key; ?>" value="<?php echo $order['coffees_id'][$key_order][$key]; ?>">
										<input type="hidden" name="coffees_name[]" id="coffees_name<?php echo $key; ?>" value="<?php echo $value; ?>">
										<input type="hidden" name="coffees_finished[]" id="coffees_finished<?php echo $key; ?>" class="item_finished" value="<?php if(isset($order['coffees_finished'][$key_order][$key])) echo $order['coffees_finished'][$key_order][$key]; ?>">																				
										<div id="coffees_check<?php echo $key; ?>" class="finished">
											<?php echo ucfirst($value); ?>
										</div>										
									</div>
									<div class="col-2 d-inline-block">
										<input class="numberQty" type="number" name="coffees_qty[]" id="coffees_qty<?php echo $key; ?>" value="<?php echo $order['coffees_qty'][$key_order][$key]; ?>" min="0">
									</div>															
								</li>
							<?php endforeach ?>
							</ul>
							<hr/>
							<?php endif ?>											
						</div>						
						<div class="col-12 text-center">
							<input type="hidden" name="id" value="<?php echo $order['id']; ?>">
							<input type="hidden" name="table_number" value="<?php echo $order['table_number']; ?>"> 
							<input type="hidden" name="people_qty" value="<?php echo $order['people_qty'] ?>">         													
							<button type="button" id="update_button" class="btn btn-outline-primary" value="/admin/comandas/update"><?php echo ucfirst($home->language['update']); ?></button>
							<button class="btn btn-outline-success" type="submit" name="action" value="add"><?php echo ucfirst($home->language['add']); ?></button>	                            
							<a class="btn btn-outline-success" href="/admin/comandas/index"><?php echo ucfirst($home->language['go_back']); ?></a>
						</div>
					</form>
					<?php if ($_SESSION['role'] === "ROLE_ADMIN") include("delete_form.php");?>
					<a class="btn btn-outline-success" target="_blank" href="/admin/printBill/print/<?php echo $order['id']; ?>"><?php echo ucwords($home->language['print_bill']); ?></a>
				</div>
			</div>
            <?php endforeach ?>							
		</div>				
	</section>			
<?php
	$home->do_html_footer();
?>