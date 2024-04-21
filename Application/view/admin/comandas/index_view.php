<?php
	declare(strict_types=1);
		
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | " . ucfirst($home->language['orders']);			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, "administration");
?>	
												<!-- SECTION WITH INFO -->
									
	<section class="col-12 p-3 p-lg-0 pe-lg-3">		
		<div class="col d-flex justify-content-center align-items-center mb-5">
			<h2 class="m-0 me-2"><?php echo ucfirst($home->language['current_orders']); ?></h2>			
		</div>

		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<?php echo $message ?? ''; ?>
			</div>
		</div>
		<div class="row d-flex justify-content-evenly">			
			<?php foreach ($result as $key => $value): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-5 text-center">
                    <div class="w-100 menuDia">
                        <h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['table']); ?>:</strong> <?php echo $value['table_number']; ?></h4>
                        <h4 class="col-5 d-inline-block"><strong><?php echo strtoupper($home->language['people_qty']); ?>:</strong> <?php echo $value['people_qty']; ?></h4>
                        <form action="/admin/comandas/show" method="post">
							<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
							<button class="btn btn-outline-success" name="action" value="show" type="submit"><?php echo ucfirst($home->language['see_data']); ?></button>
						</form>
                    </div>                    
                </div>
            <?php endforeach ?>										
		</div>
		<div class="row">
			<div>
				<a class="btn btn-primary" href="/admin/admin/adminMenus"><?php echo ucfirst($home->language['go_back']); ?></a>
			</div>			
		</div>				
	</section>			
<?php
	$home->do_html_footer();
?>