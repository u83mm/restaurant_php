<?php
	declare(strict_types=1);
	
	namespace model\classes;	

	class PageClass {			
		public function __construct(
			public string $title = "My Restaurant",
			public string $h1 = "Restaurant Your House",
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

		/**
		 * This function generates the HTML header section with specified title, meta tags, and CSS/JS files.
		 * 
		 * @param string title The title of the HTML page.
		 * @param string h1 The main heading of the HTML page. It is typically the largest and most prominent
		 * text on the page and should provide a clear and concise description of the content.
		 * @param string meta_name_description The meta tag "description" that provides a brief summary of
		 * the web page's content for search engines and users. The value of this parameter is passed as the
		 * content attribute of the meta tag.
		 * @param string meta_name_keywords The meta_name_keywords parameter is a string that contains the
		 * keywords that describe the content of the webpage. These keywords are used by search engines to
		 * index the webpage and make it easier to find for users searching for related content.
		 */
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
				<link rel="icon" type="image/gif" href="/images/favicon.ico">
				<link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">				
				<link rel="stylesheet" type="text/css" href="/css/reset.css">
				<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="/css/estilo.css">
				<link rel="stylesheet" type="text/css" href="/css/backgrounds.css">
				<script type="text/javascript" src="/js/bootstrap.bundle.min.js.js"></script>
				<script type="text/javascript" src="/js/eventos.js"></script>
				<script type="text/javascript" src="/js/ajax.js"></script>							
			</head>
			<body class="ps-3 pe-3">
				<header class="d-flex justify-content-end align-items-end align-items-xl-center header">
					<div class="col-12 col-md-7 d-none d-md-inline-block"></div>
					<div class="col-12 col-md-5">
						<h1><?php echo $this->h1; ?></h1>
					</div>										
				</header>
				<main class="container-fluid">									
<?php			
		}

		/**
		 * This function generates a navigation bar with links and displays the name of the logged-in user if
		 * there is one.
		 * 
		 * @param links An array containing the links to be displayed in the navigation bar. The keys of the
		 * array represent the name of the link, and the values represent the URL of the link. If no links
		 * are provided, the navigation bar will still be displayed, but with no links.
		 */
		public function do_html_nav($links=NULL): void
		{
?>
					<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
						<div class="container-fluid">
							<div class="col-5 col-sm-1 col-md-2 col-lg-2 col-xl-1">
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

												<!-- Show user loged -->

					<?php if(isset($_SESSION['user_name'])):?>
					<p class="text-end pe-2">Logged as <?php echo ucfirst($_SESSION['user_name']); ?></p>
					<?php endif ?>
					<noscript><h4>Tienes javaScript desactivado</h4></noscript>
<?php
		}

		/**
		 * This PHP function generates the HTML code for a website footer with a copyright notice.
		 */
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
