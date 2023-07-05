<?php
    namespace model\classes;

    class Language
    {
        public function __construct(private array $language = [])
        {
            
        }

        public function spanish() : array 
        {
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
                "our_menu"                  => "nuestra carta",
                "aperitivos"                => "aperitivos",
                "entrantes"                 => "entrantes",
                "ensaladas"                 => "ensaladas",
                "carnes"                    => "carnes",
                "pescados"                  => "pescados",
                "arroces"                   => "arroces",
                "postres"                   => "postres",
                "cafés"                     => "cafés",
                "tintos"                    => "tintos",
                "blancos"                   => "blancos",
                "rosados"                   => "rosados",
                "cavas"                     => "cavas",
                "champagne"                 => "champagne",
                "bebidas"                   => "bebidas",
                "licores"                   => "licores",
                "logged_as"                 => "logeado como",
            ];

            return $this->language;
        }

        public function english() : array 
        {
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
                "our_menu"                  => "our menu",
                "aperitivos"                => "aperitifs",
                "entrantes"                 => "starters",
                "ensaladas"                 => "salads",
                "carnes"                    => "meats",
                "pescados"                  => "fishes",
                "arroces"                   => "rices",
                "postres"                   => "desserts",
                "cafés"                     => "coffees",
                "tintos"                    => "red wines",
                "blancos"                   => "white wines",
                "rosados"                   => "pink wines",
                "cavas"                     => "sparking wine",
                "champagne"                 => "champagne",
                "bebidas"                   => "drinks",
                "licores"                   => "liquors",
                "logged_as"                 => "logged as",
            ];

            return $this->language;
        }
    }    
?>