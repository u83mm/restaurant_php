<?php
	declare(strict_types=1);
	
	namespace model\classes;	

	class PageClass {			
		public function __construct(
			public string $title = "My Restaurant",
			public string $h1 = "Restaurant",
			public string $meta_name_description = "Aquí va una descripción del sitio",
			public string $meta_name_keywords = "Restaurant Menu take away food",
			public array $nav_links = [
				"Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Login "			=> 	"/login.php",
			],
		)
		{			
			$links = new NavLinks();

			/** Configure menus by ROLE */			
			if (isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN')	$this->nav_links = $links->admin();
			if (isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_WAITER') $this->nav_links = $links->waiter();
			if (isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_USER') $this->nav_links = $links->user();

			if (isset($_SESSION['id_user'])) {
				array_pop($this->nav_links);
				$this->nav_links["Logout"] = "/login.php?action=logout"; 
			}
		}

		public function do_html_header(string $title, string $h1, string $meta_name_description, string $meta_name_keywords): void
		{
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
				<link rel="stylesheet" type="text/css" href="/css/backgrounds.css">
				<script type="text/javascript" src="/js/bootstrap.bundle.min.js.js"></script>
				<script type="text/javascript" src="/js/eventos.js"></script>
				<script type="text/javascript" src="/js/ajax.js"></script>				
			</head>
			<body class="ps-3 pe-3">
				<header class="d-flex justify-content-center align-items-center">
					<h1><?php echo $this->h1; ?></h1>
				</header>
				<main class="container-fluid">
					
<?php			
		}

		public function do_html_nav($links=NULL): void
		{
?>
					<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
						<div class="container-fluid">
							<div class="col-5 col-sm-1 col-md-3 col-lg-2 col-xl-1">
								<a class="navbar-brand" href="/"><img src="/images/main_logo.png" class="img-fluid float-start" alt="imagen_logo"></a>
							</div>
							<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#my_nav" aria-controls="my_nav" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse" id="my_nav">
								<ul class="nav navbar-nav justify-content-center w-100">
<?php
							foreach($links as $name => $url) {								
?>
									<li class="nav-item d-lg-inline-block"><a class="nav-link" href="<?php echo $url; ?>"><?php echo $name; ?></a></li>
<?php
							}
?>
								</ul>
							</div>														
						</div>
					</nav>
					<noscript><h4>Tienes javaScript desactivado</h4></noscript>
<?php
		}

		public function do_html_footer(): void
		{
?>					
				</main>	
				<footer class="container-fluid d-flex justify-content-center align-items-center">
					<p>Copyright &copy; reserved <?php echo date("Y"); ?></p>
				</footer>			
			</body>
		</html>
<?php		
		}
	}
?>
