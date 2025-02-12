<?php
    namespace Application\model\classes;

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
                    "Carta"				=> 	"/menu",
                    "Registrate"		=> 	"/register",
                    "Administración"	=>	"/admin/admin/adminMenus",
                    "Pedidos"			=>	"/orders/order/new",
                    "Reservas"			=> 	"/reservations/reservation/index",
                    "Logeate"			=> 	"/login",                    
                ];

                return $this->nav_links;
            }

            // English nav menu for admin
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu",
				"Sign up"		    => 	"/register",
				"Administration"	=>	"/admin/admin/adminMenus",
				"Orders"			=>	"/orders/order/new",
                "Reservations"		=> 	"/reservations/reservation/index",
				"Login"			    => 	"/login",
            ];

            return $this->nav_links;
        }


        /** 
         * Waiter nav menu 
         * 
         * @return array
         * */
        public function waiter(): array
        {
            // Spanish nav menu for ROLE waiter
            if($_SESSION['language'] == "spanish") {
                $this->nav_links = [
                    "Inicio"			=>	"/",
                    "Carta"				=> 	"/menu",
                    "Comandas"          => 	"/admin/comandas/index",                                
                    "Pedidos"			=>	"/orders/order/new",
                    "Logeate"			=> 	"/login",
                ];

                return $this->nav_links;
            }

            // English nav menu for ROLE waiter
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu",
                "Orders List"       => 	"/admin/comandas/index", 								
				"Orders"			=>	"/orders/order/new",
				"Login"			    => 	"/login",
            ];

            return $this->nav_links;
        }


        public function user(): array
        {
            // Spanish nav menu for ROLE user
            if($_SESSION['language'] == "spanish") {
                $this->nav_links = [
                    "Inicio"			=>	"/",
                    "Carta"				=> 	"/menu",                    
                    "Reservas"			=> 	"/reservations/reservation/index",                                    
                    "Logeate"			=> 	"/login",                   
                ];

                return $this->nav_links;
            }
            
            // English nav menu for ROLE user
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu",				
                "Reservations"		=> 	"/reservations/reservation/index",			
				"Login"			    => 	"/login",                
            ];

            return $this->nav_links;
        }    
    }    
?>