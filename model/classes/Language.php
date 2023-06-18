<?php
    namespace model\classes;

    class Language
    {
        public function __construct(private array $language = [])
        {
            
        }

        public function spanish() : array {
            $this->language = [
                "flag_text"     => "English",
                "flag"          => "english",
                "welcome"       => "bienvenido",
                "day_menu"      => "menú del día",
                "first_plates"  => "primeros platos",
                "seconds"       => "segundos platos",
                "desserts"      => "postres",
                "price"         => "precio",
            ];

            return $this->language;
        }

        public function english() : array {
            $this->language = [
                "flag_text"     => "Español",
                "flag"          => "spanish",
                "welcome"       => "welcome",
                "day_menu"      => "day's menu",
                "first_plates"  => "starters",
                "seconds"       => "main dishes",
                "desserts"      => "desserts",
                "price"         => "price",
            ];

            return $this->language;
        }
    }    
?>