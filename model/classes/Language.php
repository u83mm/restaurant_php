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
                "flag_text"                 => "english",
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
                "aperitifs"                 => "aperitivos",
                "entrantes"                 => "entrantes",
                "starters"                  => "entrantes",
                "ensaladas"                 => "ensaladas",
                "salads"                    => "ensaladas",
                "carnes"                    => "carnes",
                "meats"                     => "carnes",
                "pescados"                  => "pescados",
                "fishes"                    => "pescados",
                "arroces"                   => "arroces",
                "rices"                     => "arroces",
                "postres"                   => "postres",
                "desserts"                  => "postres",
                "cafés"                     => "cafés",
                "coffees"                   => "cafés",
                "tintos"                    => "tintos",
                "red wines"                 => "tintos",
                "blancos"                   => "blancos",
                "white wines"               => "blancos",
                "rosados"                   => "rosados",
                "pink wines"                => "rosados",
                "cavas"                     => "cavas",
                "sparking wine"             => "cavas",
                "champagne"                 => "champagne",
                "bebidas"                   => "bebidas",
                "drinks"                    => "bebidas",
                "licores"                   => "licores",
                "liquors"                   => "licores",
                "olivas rellenas"           => "olivas rellenas",
                "patatas chips"             => "patatas chips",
                "anchoas de la casa"        => "anchoas de la casa",
                "go_back"                   => "volver atrás",
                "logged_as"                 => "logeado como",
            ];

            return $this->language;
        }

        public function english() : array 
        {
            $this->language = [
                "flag_text"                 => "español",
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
                "olivas rellenas"           => "stuffed olives",
                "patatas chips"             => "bag of chips",
                "anchoas de la casa"        => "house anchovies",
                "go_back"                   => "go back",
                "logged_as"                 => "logged as",
            ];

            return $this->language;
        }
    }    
?>