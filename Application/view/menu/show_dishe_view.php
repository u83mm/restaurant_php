<?php
	declare(strict_types=1);
		
	use Application\model\classes\PageClass;

	$home = new PageClass();
	$home->title = "My Restaurant | Menu";			

	$home->do_html_header($home->title, $home->h1, $home->meta_name_description, $home->meta_name_keywords);
	$home->do_html_nav($home->nav_links, $home->language['nav_link_menu']);
?>	
								<!-- SECTION WITH INFO -->
	<section class="col-12 col-lg-9 p-sm-0 pe-lg-4">
		<div class="col mb-5 <?php echo $dishe['menu_category']; ?>"></div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center align-items-center mb-3">
				<h2 class="m-0 me-2"><?php echo ucwords($dishe['name']); ?></h2>				
			</div>
		</div>		
		<div class="row">
            <div class="clear-fix">
                <img class="float-start me-3" src="<?php echo $dishe_picture ; ?>" alt="dishe-image">                
                <?php echo $description; ?>
            </div>		
		</div>
		<div class="row">
			<div class="col-3 d-none d-xl-block"></div>
			<div class="col-12 col-md-3 p-3 ps-2 text-center text-md-start">
				<h3><?php echo ucfirst($home->language['price']); ?>: <?php echo number_format(floatval($dishe['price']), 2, ",", ".") ; ?>€</h3>
			</div>


			<!-- Select dish and Qty as First, Second, Dessert, or Coffe and liquors -->

			<div class="col-12 col-md-7 col-xl-5 text-md-end ps-4 pe-4 pb-4">
			<?php if(isset($_SESSION['role']) && ($_SESSION['role'] === "ROLE_WAITER" || $_SESSION['role'] === "ROLE_ADMIN")): ?>
				<form action="/orders/order/new" method="post">
					<input type="hidden" name="name" value="<?php echo $dishe['name']; ?>">
					<label class="col-2 col-form-label" for="qty"><?php echo ucfirst($home->language['qty']); ?></label>
					<input class="numberQty" type="number" name="qty" id="qty" min="0" value="0">
					<select class="align-middle" name="place" id="place">
						<option value="">- <?php echo ucfirst($home->language['select']); ?> -</option>
						<option value="aperitifs"><?php echo ucfirst($home->language['aperitif']); ?></option>
						<option value="firsts"><?php echo ucfirst($home->language['primero']); ?></option>
						<option value="seconds"><?php echo ucfirst($home->language['segundo']); ?></option>
						<option value="desserts"><?php echo ucfirst($home->language['postre']); ?></option>
						<option value="drinks"><?php echo ucfirst($home->language['drink']); ?></option>
						<option value="coffees"><?php echo ucfirst($home->language['coffees_and_liquors']); ?></option>
					</select>
					<div class="col-12 col-md-2 text-center text-md-start d-inline-block">
						<button class="btn btn-outline-success mt-3 m-md-0"><?php echo ucfirst($home->language['to_order']); ?></button>
					</div>					
				</form>				
			<?php endif ?>
			</div>		
		</div>
		<div class="row">
			<form class="mb-3 text-center text-lg-start" action="/menu/showDishesByTheirCategory/<?php echo $dishe['menu_id']; ?>" method="post">
				<button class="btn btn-primary" type="submit" name="category" value="<?php echo $dishe['menu_category']; ?>"><?php echo ucfirst($home->language['go_back']); ?></button>
				<?php if(isset($_SESSION['role']) && ($_SESSION['role'] === "ROLE_WAITER" || $_SESSION['role'] === "ROLE_ADMIN")): ?>
				<a class="btn btn-outline-success" href="/admin/dishes/edit/<?php echo $dishe['dishe_id']; ?>"><?php echo ucfirst($home->language['edit']); ?></a>
				<?php endif ?>
			</form>			
		</div>			
	</section>
								<!--- ASIDE SHOWING MENU'S DAY -->
	<?php include(SITE_ROOT . "/../Application/view/menu/menu_day_view.php"); ?>
<?php
	$home->do_html_footer();
?>