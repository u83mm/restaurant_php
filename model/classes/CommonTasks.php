<?php
    namespace model\classes;

    class CommonTasks
    {
        // da formato a fechas que son Strings para que las muestre en formato ('dd-mm-YYYY')
        
        public function showDayMonthYear(string $date = null): string
        {
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            return $day . "/" . $month . "/" . $year;
        }


        // Calcula el valor de x para usarlo en la función pagination1

        private function return_x_value($pagina, $current_page) { 
            if($current_page == 1) {
                $x = $current_page;
            }
            else if(($current_page > 4) && ($current_page < ($pagina - 2))) {
                $x = $current_page - 2;
            }
            else if($current_page >= ($pagina - 2) && ($pagina > 4)) {
                $x = $pagina - 4;
            }
            else {
                $x = 1;
            }
            return $x;
        }


        // Muestra paginación 

        public function pagination1($pagina, $pagerows, $current_page) {
            $x = $this->return_x_value($pagina, $current_page);
                
            for($i = 1; $i <= 5; $i++) {
                if($x > $pagina) {
                    return;
                }
                else if($x == $current_page) {
                    $s =($pagerows * $x) - $pagerows; ?>
                    <li class='page-item'>                        
                        <form class="active" action="/admin/admin_dishes.php" method="POST">
                            <input type="hidden" name="s" value="<?php echo $s; ?>">
                            <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                            <button class="page-link" type="submit"><span><?php echo $x; ?></span></button>                           
                        </form>                       
                    </li>                    
<?php           }   
                else {
                    $s = ($pagerows * $x) - $pagerows; ?>
                    <li class='page-item'>
                        <form action="/admin/admin_dishes.php" method="POST">
                            <input type="hidden" name="s" value="<?php echo $s; ?>">
                            <input type="hidden" name="p" value="<?php echo $pagina; ?>">
                            <button class="page-link" type="submit"><?php echo $x; ?></button> 
                        </form>
                    </li>                   
<?php           }				
                $x++;	
            }
        }


        // Función para usar en redimensionado de imágenes al subirlas 

        public function createImageFromSource($source, $type) {            
            // JPG
            if(preg_match('/jpg|jpeg/', $type)) {                             
                $data = @ImageCreateFromJPEG($source);               
            }
            // PNG
            if(preg_match('/png/', $type)) {
                $data = ImageCreateFromPNG($source);
            }
            // GIF
            if(preg_match('/gif/', $type)) {
                $data = ImageCreateFromGIF($source);
            }
            return $data;
        }


        // Función para redimiensionado de imágenes 
        
        public function resizeImage($original, $w, $h) {
            $thumbnail = ImageCreateTrueColor($w, $h);
            ImageColorTransparent($thumbnail, ImageColorAllocateAlpha($thumbnail, 0, 0, 0, 127));
            ImageAlphaBlending($thumbnail, false);
            ImageSaveAlpha($thumbnail, true);
            $x = ImageSX($original);
            $y = ImageSY($original);
            $scale = min($x / $w, $y / $h);
            ImageCopyResampled($thumbnail, $original, 0, 0, ($x - ($w * $scale)) / 2, ($y - ($h * $scale)) / 2, $w, $h, $w * $scale, $h * $scale);
            return $thumbnail;
        }


        //Convierte una dirección absoluta a una para poder ver la ruta en navegador

        function getWebPath(string $file_system_path): string
        {            
            return str_replace($_SERVER['DOCUMENT_ROOT'], '', $file_system_path);
        }


        // Delete picture from server
        public function deletePicture(string $cadena = null): void
        {
            unlink($cadena);
        }
        
        public function divideTextInParagrahs(string $text): string
        {
            $paragraphs = explode("\n", $text);
            $string = "";           

            foreach ($paragraphs as $key => $value) {
                if ($value == "") continue;
                $string .= "<p>$value</p>";                            
            }                       

            return $string;
        }
    }
?>