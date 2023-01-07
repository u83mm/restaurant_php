<?php
	declare(strict_types=1);
	
	namespace model\classes;

	class PageClass {
		public $title = "My Restaurant";
		public $h1 = "Restaurant";
		public $meta_name_description = "Aquí va una descripción del sitio";
		public $meta_name_keywords = "Restaurant Menu take away food";
		public $menus = array (
			"Home"				=>	"/",
			"Menu"				=> 	"/menu/menu.php",
			"Registration"		=> 	"/register.php",
			"Administration"	=>	"/admin/admin.php",
			"Login "			=> 	"/login.php",			
		);

		public function __construct()
		{
			if (isset($_SESSION['id_user'])) {
				array_pop($this->menus);
				$this->menus["Logout"] = "/login.php?action=logout"; 
			}
		}

		public function do_html_header(string $title, string $h1, string $meta_name_description, string $meta_name_keywords) {
?>
		<!DOCTYPE html>
		<html lang="es">
			<head>
				<meta charset='UTF-8' />
				<meta name="title" content="Web site" /> 
				<meta name="description" content="<?php echo $this->meta_name_description; ?>" />
				<meta name="keywords" content="<?php echo $this->meta_name_keywords; ?>" />
				<meta name="robots" content="All" />  
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
				<title><?php echo $this->title; ?></title>
				<!-- <link rel="shorcut icon" href="imagen para el favicon"> -->
				<link rel="icon" type="image/gif" href="/images/favicon.ico">				
				<link rel="stylesheet" type="text/css" href="/css/reset.css">
				<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="/css/estilo.css">
				<script type="text/javascript" src="/js/bootstrap.bundle.min.js.js"></script>
				<script type="text/javascript" src="/js/eventos.js"></script>
			</head>
			<body class="ps-3 pe-3">
				<header class="d-flex justify-content-center align-items-center">
					<h1><?php echo $this->h1; ?></h1>
				</header>
				<main class="container-fluid">
					
<?php			
		}

		public function do_html_nav($menus=NULL) {
			?>
						<nav class="navbar navbar-light bg-light sticky-top">
							<div class="container-fluid">
								<div class="col-3 col-sm-1 col-lg-1">
									<a class="navbar-brand" href="/"><img src="images/logo_pb.png" class="img-fluid float-start" alt="imagen_logo"></a>
								</div>
								<ul class="nav nav-pills">
<?php
							foreach($this->menus as $name => $url) {
								if((!isset($_SESSION['role']) && $name === "Administration") || (isset($_SESSION['role']) && $_SESSION['role'] !== "ROLE_ADMIN" && $name === "Administration")) continue;
?>
									<li class="nav-item "><a class="nav-link" href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
<?php
							}
?>
								</ul>
								<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
								  <span class="navbar-toggler-icon"></span>
								</button>
								<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
									<div class="offcanvas-header">
										<h5 class="offcanvas-title" id="offcanvasNavbarLabel">Auto Gest</h5>
										<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
									</div>
									<div class="offcanvas-body">
										<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
											<li class="nav-item">
												<a class="nav-link active" aria-current="page" href="/"><i class="fas fa-home fa-lg fa-fw"></i> Home</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="/menu/menu.php"><i class="fas fa-video fa-lg fa-fw"></i> Menu</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="/register.php"><i class="fas fa-video fa-lg fa-fw"></i> Registration</a>
											</li>
										<?php if(isset($_SESSION['role']) && $_SESSION['role'] === "ROLE_ADMIN") { ?>								
											<li class="nav-item">
												<a class="nav-link" href="/admin/admin.php"><i class="fas fa-envelope fa-lg fa-fw"></i> Administration</a>
											</li>
										<?php } ?>
											<li class="nav-item">
										<?php if(!isset($_SESSION['role'])) { ?>
												<a class="nav-link" href="/login.php"><i class="fas fa-envelope fa-lg fa-fw"></i> Login</a>
										<?php }else { ?>
												<a class="nav-link" href="/login.php?action=logout"><i class="fas fa-envelope fa-lg fa-fw"></i> Logout</a>
										<?php } ?>
											</li>
											<li class="nav-item dropdown">
												<a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Link</a>
												<ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
													<li>
														<a class="dropdown-item" href="/">Link</a>
													</li>																		
												</ul>
											  </li>
										</ul>						
									</div>
								</div>
							</div>
						</nav>
						<noscript><h4>Tienes javaScript desactivado</h4></noscript>
			<?php
					}

		public function do_html_footer() {
?>					
				</main>	
				<footer class="container-flu">
					<p>Copyright &copy; reserved <?php echo date("Y"); ?></p>
				</footer>			
			</body>
		</html>
<?php		
		}
	}
?>
