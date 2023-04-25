<?php
    namespace model\classes;

    class MenusClass
    {
        public function __construct(private array $menus = [])
        {
            
        }

        public function admin(): array
        {
            $this->menus = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",
				"Administration"	=>	"/admin/admin.php",
				"Comandas"			=>	"/",
				"Login "			=> 	"/login.php",
            ];

            return $this->menus;
        }

        public function waiter(): array
        {
            $this->menus = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Comandas"			=>	"/",
				"Login "			=> 	"/login.php",
            ];

            return $this->menus;
        }
        public function user(): array
        {
            $this->menus = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Login "			=> 	"/login.php",
            ];

            return $this->menus;
        }

        public function nonLogged(): array
        {
            $this->menus = [
                "Home"				=>	"/",
				"Menu"				=> 	"/menu/menu.php",
				"Registration"		=> 	"/register.php",				
				"Login "			=> 	"/login.php",
            ];

            return $this->menus;
        }
    }    
?>