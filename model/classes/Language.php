<?php
    namespace model\classes;

    class Language
    {
        public function __construct(private array $language = [])
        {
            
        }

        public function spanish() : array {
            $this->language = [
                "flag_text"                 => "English",
                "flag"                      => "english",
                "welcome"                   => "bienvenido",
                "day_menu"                  => "menú del día",
                "first_plates"              => "primeros platos",
                "seconds"                   => "segundos platos",
                "desserts"                  => "postres",
                "price"                     => "precio",
                "menu_day_footer"           => "Bebida: agua, vino o refresco",
                "nav_link_home"             => "inicio",
                "nav_link_menu"             => "carta",
                "nav_link_logout"           => "salir",
                "nav_link_sign_up"          => "registrate",
                "nav_link_administration"   => "administración",
                "nav_link_orders"           => "pedidos",
            ];

            return $this->language;
        }

        public function english() : array {
            $this->language = [
                "flag_text"                 => "Español",
                "flag"                      => "spanish",
                "welcome"                   => "welcome",
                "day_menu"                  => "day's menu",
                "first_plates"              => "starters",
                "seconds"                   => "main dishes",
                "desserts"                  => "desserts",
                "price"                     => "price",
                "menu_day_footer"           => "Drink water, wine or refresh drink",
                "nav_link_home"             => "home",
                "nav_link_menu"             => "menu",
                "nav_link_logout"           => "logout",
                "nav_link_sign_up"          => "sign up",
                "nav_link_administration"   => "administration",
                "nav_link_orders"           => "orders",
            ];

            return $this->language;
        }
    }    
?>