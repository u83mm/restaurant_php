<?php
    namespace model\classes;

    class NavLinks
    {
        public function __construct(private array $nav_links = [])
        {
            
        }

        /**
         * The function returns an array of menu items for an admin page in PHP.
         * 
         * @return array An array of menu items with their corresponding URLs.
         */
        public function admin(): array
        {
            // Spanish nav menu for admin
            if($_SESSION['language'] == "spanish") {
                $this->nav_links = [
                    "Inicio"			=>	"/",
                    "Carta"				=> 	"/menu/menu.php",
                    "Registrate"		=> 	"/register.php",
                    "Administración"	=>	"/admin/admin.php",
                    "Pedidos"			=>	"/orders/index.php",
                    "Reservas"			=> 	"/reservation.php",
                    "Logeate"			=> 	"/login.php",                    
                ];

                return $this->nav_links;
            }

            // English nav menu for admin
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Sign up"		    => 	"/register.php",
				"Administration"	=>	"/admin/admin.php",
				"Orders"			=>	"/orders/index.php",
                "Reservations"		=> 	"/reservation.php",
				"Login "			=> 	"/login.php",
            ];

            return $this->nav_links;
        }


        public function waiter(): array
        {
            // Spanish nav menu for ROLE waiter
            if($_SESSION['language'] == "spanish") {
                $this->nav_links = [
                    "Inicio"			=>	"/",
                    "Carta"				=> 	"/menu/menu.php",                                 
                    "Pedidos"			=>	"/orders/index.php",
                    "Logeate"			=> 	"/login.php",
                ];

                return $this->nav_links;
            }

            // English nav menu for ROLE waiter
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",								
				"Orders"			=>	"/orders/index.php",
				"Login "			=> 	"/login.php",
            ];

            return $this->nav_links;
        }


        public function user(): array
        {
            // Spanish nav menu for ROLE user
            if($_SESSION['language'] == "spanish") {
                $this->nav_links = [
                    "Inicio"			=>	"/",
                    "Carta"				=> 	"/menu/menu.php",
                    "Registrate"		=> 	"/register.php",
                    "Reservas"			=> 	"/reservation.php",                                    
                    "Logeate"			=> 	"/login.php",                   
                ];

                return $this->nav_links;
            }
            
            // English nav menu for ROLE user
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Sign up"		    => 	"/register.php",
                "Reservations"		=> 	"/reservation.php",			
				"Login "			=> 	"/login.php",                
            ];

            return $this->nav_links;
        }    
    }    
?>