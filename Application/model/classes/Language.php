<?php
    namespace model\classes;

    require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

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
            $spanish_dict = $query->selectAll('spanish_dict');                      

            foreach ($spanish_dict as $key => $value) {
                $this->language[$value['key_word']] = $value['value'];
            }
            
            return $this->language;
        }

        public function english() : array 
        {
            global $dbcon;

            $query = new Query();            
            $english_dict = $query->selectAll('english_dict');            

            foreach ($english_dict as $key => $value) {
                $this->language[$value['key_word']] = $value['value'];
            }            

            return $this->language;
        }
    }    
?>