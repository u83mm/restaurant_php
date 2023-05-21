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
		<div class="row d-flex justify-content-evenly">			
			<?php foreach ($result as $key => $value): ?>
                <div class="col-6 col-md-3 col-xl-2 mb-5 text-center">
                    <div class="w-100 menuDia">
                        <h4 class="col-5 d-inline-block"><strong>MESA:</strong> <?php echo $value['table_number']; ?></h4>
                        <h4 class="col-5 d-inline-block"><strong>PERS.:</strong> <?php echo $value['people_qty']; ?></h4>
                        <form action="/admin/admin_comandas.php" method="post">
							<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
							<button class="btn btn-outline-success" name="action" value="show" type="submit">Ver datos</button>
						</form>
                    </div>                    
                </div>
            <?php endforeach ?>								
		</div>				
	</section>			
<?php
	$home->do_html_footer();
?>