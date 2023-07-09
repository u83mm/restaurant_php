<?php
    namespace model\classes;

    require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");	

    class Language
    {
        public function __construct(private array $language = [])
        {
            
        }

        public function spanish() : array 
        {
            global $dbcon;

            $query = new Query();
            $spanish_dict = $query->selectAll('spanish_dict', $dbcon);            

            foreach ($spanish_dict as $key => $value) {
                $this->language[$value['key_word']] = $value['value'];
            }

            /*$this->language = [
                "flag_text"                     => "english",
                "flag"                          => "english",
                "welcome"                       => "bienvenido",
                "day_menu"                      => "menú del día",
                "first_plates"                  => "primeros platos",
                "seconds"                       => "segundos platos",
                "desserts"                      => "postres",
                "price"                         => "precio",
                "menu_day_footer"               => "bebida: agua, vino o refresco",
                "nav_link_home"                 => "inicio",
                "nav_link_menu"                 => "carta",
                "nav_link_logout"               => "salir",
                "nav_link_sign_up"              => "registrate",
                "nav_link_administration"       => "administración",
                "nav_link_orders"               => "pedidos",
                "our_menu"                      => "nuestra carta",
                "send"                          => "enviar",
                "aperitivos"                    => "aperitivos",
                "aperitifs"                     => "aperitivos",
                "entrantes"                     => "entrantes",
                "starters"                      => "entrantes",
                "ensaladas"                     => "ensaladas",
                "salads"                        => "ensaladas",
                "carnes"                        => "carnes",
                "meats"                         => "carnes",
                "pescados"                      => "pescados",
                "fishes"                        => "pescados",
                "arroces"                       => "arroces",
                "rices"                         => "arroces",
                "postres"                       => "postres",
                "desserts"                      => "postres",
                "cafés"                         => "cafés",
                "coffees"                       => "cafés",
                "tintos"                        => "tintos",
                "red wines"                     => "tintos",
                "blancos"                       => "blancos",
                "white wines"                   => "blancos",
                "rosados"                       => "rosados",
                "pink wines"                    => "rosados",
                "cavas"                         => "cavas",
                "sparking wine"                 => "cavas",
                "champagne"                     => "champagne",
                "bebidas"                       => "bebidas",
                "drinks"                        => "bebidas",
                "licores"                       => "licores",
                "liquors"                       => "licores",
                "olivas rellenas"               => "olivas rellenas",
                "patatas chips"                 => "patatas chips",
                "anchoas de la casa"            => "anchoas de la casa",
                "macarrones a la boloñesa"      => "macarrones a la boloñesa",
                "espaguetis a la carbonara"     => "espaguetis a la carbonara",
                "ensalada catalana"             => "ensalada catalana",
                "catalan salad"                 => "ensalada catalana",
                "ensalada mixta"                => "ensalada mixta",
                "bistec con patatas y verduras" => "bistec con patatas y verduras",
                "entrecot al gusto"             => "entrecote al gusto",
                "salmón a la plancha"           => "salmón a la plancha",
                "paella valenciana"             => "paella valenciana",
                "arroz con setas"               => "arroz con setas",
                "crema catalana"                => "crema catalana",
                "creps de la casa"              => "creps de la casa",
                "café solo"                     => "café sólo",
                "café cortado"                  => "café cortado",
                "tinto de la casa"              => "tinto de la casa",
                "blanco de la casa"             => "blanco de la casa",
                "refresco de cola"              => "refresco de cola",
                "agua mineral"                  => "agua mineral",
                "jarra de cerveza"              => "jarra de cerveza",
                "go_back"                       => "volver atrás",
                "logged_as"                     => "logeado como",
                "captcha_text"                  => "introduce la serie de caracteres",
                "alert_access"                  => "<p class='alert alert-danger text-center container'>Hola <strong>" . ucfirst($_SESSION['user_name']) . "</strong>, no tienes privilegios para realizar esta acción.</p>",
                "alert_login"                   => "<p class='alert alert-danger text-center'>" . ucfirst("comprueba tus credenciales") . "</p>",
                "alert_delete"                  => "estás seguro de querer eliminar el registro",
                "register_form"                 => "formulario de registro",
                "main_menu"                     => "menú principal",
                "products"                      => "productos",
                "menu_day_price"                => "precio del menú del día",
                "show_list"                     => "listado",
                "search"                        => "buscar",
                "new"                           => "nuevo",
                "users"                         => "usuarios",
                "categories"                    => "categorías",
                "orders"                        => "comandas",
                "go_to_list"                    => "ir al listado",
                "product_list"                  => "listado de productos",
                "image"                         => "imagen",
                "name"                          => "nombre",
                "category"                      => "categoría",
                "available"                     => "disponible",
                "options"                       => "opciones",
                "edit"                          => "editar",
                "delete"                        => "eliminar",
                "carta"                         => "carta",
                "primero"                       => "primero",
                "segundo"                       => "segundo",
                "postre"                        => "postre",
                "si"                            => "si",
                "no"                            => "no",
                "prev"                          => "ant",
                "next"                          => "sig",
                "new_product"                   => "nuevo producto",
                "description"                   => "descripción",
                "dish_type"                     => "tipo de plato",
                "select"                        => "selecciona",
                "product_details"               => "detalles del producto",
                "change_image"                  => "cambiar imagen",
                "update"                        => "actualizar",
            ];*/

            return $this->language;
        }

        public function english() : array 
        {
            $this->language = [
                "flag_text"                     => "español",
                "flag"                          => "spanish",
                "welcome"                       => "welcome",
                "day_menu"                      => "day's menu",
                "first_plates"                  => "starters",
                "seconds"                       => "main dishes",
                "desserts"                      => "desserts",
                "price"                         => "price",
                "menu_day_footer"               => "drink: water, wine or refresh drink",
                "nav_link_home"                 => "home",
                "nav_link_menu"                 => "menu",
                "nav_link_logout"               => "logout",
                "nav_link_sign_up"              => "sign up",
                "nav_link_administration"       => "administration",
                "nav_link_orders"               => "orders",
                "our_menu"                      => "our menu",
                "send"                          => "send",
                "aperitivos"                    => "aperitifs",
                "entrantes"                     => "starters",
                "ensaladas"                     => "salads",
                "carnes"                        => "meats",
                "pescados"                      => "fishes",
                "arroces"                       => "rices",
                "postres"                       => "desserts",
                "cafés"                         => "coffees",
                "tintos"                        => "red wines",
                "blancos"                       => "white wines",
                "rosados"                       => "pink wines",
                "cavas"                         => "sparking wine",
                "champagne"                     => "champagne",
                "bebidas"                       => "drinks",
                "licores"                       => "liquors",
                "olivas rellenas"               => "stuffed olives",
                "patatas chips"                 => "bag of chips",
                "anchoas de la casa"            => "house anchovies",
                "macarrones a la boloñesa"      => "macaroni bolognese",
                "espaguetis a la carbonara"     => "spaghetti carbonara",
                "ensalada catalana"             => "catalan salad",
                "catalan salad"                 => "catalan salad",
                "ensalada mixta"                => "mixt salad",
                "bistec con patatas y verduras" => "steak with potatoes and vegetables",
                "entrecot al gusto"             => "entrecote to taste",
                "salmón a la plancha"           => "grilled salmon",
                "paella valenciana"             => "valencian paella",
                "arroz con setas"               => "rice with mushrooms",
                "crema catalana"                => "catalan cream",
                "creps de la casa"              => "house pancakes",
                "café solo"                     => "black coffee",
                "café cortado"                  => "small white coffee",
                "tinto de la casa"              => "House red wine",
                "blanco de la casa"             => "House white wine",
                "refresco de cola"              => "cola drink",
                "agua mineral"                  => "mineral water",
                "jarra de cerveza"              => "beer jar",
                "go_back"                       => "go back",
                "logged_as"                     => "logged as",
                "captcha_text"                  => "enter the code shown above",
                "alert_access"                  => "<p class='alert alert-danger text-center container'>Hi <strong>" . ucfirst($_SESSION['user_name']) . "</strong>, you don't have privileges to do this action.</p>",
                "alert_login"                   => "<p class='alert alert-danger text-center'>" . ucfirst("check your credentials") . "</p>",
                "alert_delete"                  => "are you sure you want to delete it",
                "register_form"                 => "register form",
                "main_menu"                     => "main menu",
                "products"                      => "products",
                "menu_day_price"                => "menu's price of the day",
                "show_list"                     => "show list",
                "search"                        => "search",
                "new"                           => "new",
                "users"                         => "users",
                "categories"                    => "categories",
                "orders"                        => "orders",
                "go_to_list"                    => "go to the list",
                "product_list"                  => "product listing",
                "image"                         => "image",
                "name"                          => "name",
                "category"                      => "category",
                "available"                     => "available",
                "options"                       => "options",
                "edit"                          => "edit",
                "delete"                        => "delete",
                "carta"                         => "menu",
                "primero"                       => "firts",
                "segundo"                       => "second",
                "postre"                        => "dessert",
                "si"                            => "yes",
                "no"                            => "no",
                "prev"                          => "prev",
                "next"                          => "next",
                "new_product"                   => "new product",
                "description"                   => "description",
                "dish_type"                     => "dish type",
                "select"                        => "select",
                "product_details"               => "product details",
                "change_image"                  => "change image",
                "update"                        => "update",
                "hi"                            => "hi",
            ];

            return $this->language;
        }
    }    
?>