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
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",
				"Administration"	=>	"/admin/admin.php",
				"Orders"			=>	"/orders/index.php",
				"Login "			=> 	"/login.php",
            ];

            return $this->nav_links;
        }


        public function waiter(): array
        {
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Orders"			=>	"/orders/index.php",
				"Login "			=> 	"/login.php",
            ];

            return $this->nav_links;
        }


        public function user(): array
        {
            $this->nav_links = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Login "			=> 	"/login.php",
            ];

            return $this->nav_links;
        }    
    }    
?>