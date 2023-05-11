<?php
	declare(strict_types=1);
		
	use model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Captcha";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);	
?>	
								<!--- SECTION WITH INFO -->
	<section class="col-12 p-sm-0 pe-lg-3">
		<div class="col mb-3 mainImg"></div>
		<div class="col d-flex justify-content-center align-items-center mb-3">
			<h2 class="m-0 me-2">WWW.RESTAURANT.COM</h2>			
		</div>

		<!-- Captcha -->
		<div class="row">
			<div class="col col-lg-8 mx-lg-auto text-center mb-5">
			<?php foreach ($images as $image): ?>
				<img class="col-1"src="/images/captcha/<?php echo $image ?>" alt="captcha image">
			<?php endforeach ?>
			</div>
		</div>
					
		<div class="row">
			<div class="col col-lg-8 mx-auto">
				<form class="col col-md-6 mx-md-auto" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="col">
						<?php echo $this->message; ?>
						<p class="text-center">Enter the code shown above:</p>
					</div>
					<div class="col mb-3 mb-md-5">
						<label class="form-label" for="captcha">CAPTCHA:</label>
						<div class="col-4 d-inline-block">
							<input type="hidden" name="phrase" value="<?php echo $phrase; ?>">
							<input class="form-control" type="text" name="captcha" id="captcha" maxlength="6" required>			
						</div>	
					</div>              									
					<!--<img src="/view/captcha/captcha_view.php" alt="CAPTCHA"><br>-->
					<div class="col text-center">
						<button class="btn btn-outline-success" name="action" value="test_captcha" type="submit">Send</button>
					</div>										
				</form>
			</div>            
		</div>
	</section>	
<?php
	$home->do_html_footer();
?>
