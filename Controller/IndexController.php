<?php
    declare(strict_types=1);
    
    namespace Controller;

    use model\captcha\SingleChar;
    use model\captcha\Strategy\{LineFill,DotFill,Shadow,RotateText};
    use model\classes\QueryMenu;
    use model\classes\Validate;

    class IndexController
    {
        public function __construct(private object $dbcon = DB_CON, private string $message = "")
        {
                        
        }

      /**
       * This function selects dishes of the day and calculates the menu's day price before including
       * the main view.
       */
        public function index(): void
        {                                 
            try {                                                                                                          
                $menuDayQuery = new QueryMenu();            

                $primeros = $menuDayQuery->selectDishesOfDay("primero", $this->dbcon);
                $segundos = $menuDayQuery->selectDishesOfDay("segundo", $this->dbcon);
                $postres = $menuDayQuery->selectDishesOfDay("postre", $this->dbcon);


                /** Calculate menu's day price */
                $menuDayPrice = $menuDayQuery->getMenuDayPrice($this->dbcon);                                
                                                        
                include(SITE_ROOT . "/../view/main_view.php");

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }

        public function showCaptcha():void
        {                                                            
            if(isset($_SESSION['role'])) {
                $this->index();
                die;
            }
            
            $_SESSION['user_name'] = "";

            define('NUM_BYTES', 3);
            define('FONT_FILE', SITE_ROOT . '/ttf/FreeSansBold.ttf');
            define('IMG_DIR', SITE_ROOT . '/images/captcha');

            $strategies = ['rotate', 'line', 'line','dot', 'dot', 'shadow']; 

            $phrase = strtoupper(bin2hex(random_bytes(NUM_BYTES)));            
            $length = strlen($phrase);
            $images = [];        

            try {
                for ($x = 0; $x < $length; $x++) {
                    $char = new SingleChar($phrase[$x], FONT_FILE);
                    $char->writeFill();
                    shuffle($strategies);                
    
                    foreach ($strategies as $item) {
                        $func = match ($item) {
                            'rotate' => RotateText::writeText($char),
                            'line'   => LineFill::writeFill($char, rand(1, 10)),
                            'dot'    => DotFill::writeFill($char, rand(10, 20)),
                            'shadow' => function ($char) {
                                $num = rand(1, 8);
                                $r   = rand(0x70, 0xEF);
                                $g   = rand(0x70, 0xEF);
                                $b   = rand(0x70, 0xEF);
    
                                return Shadow::writeText($char, $num, $r, $g, $b);
                            },
                            'default' => TRUE
                        };
    
                        if (is_callable($func)) $func($char);
                    }
    
                    $char->writeText();
                    $fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';        
                    $char->save(IMG_DIR . '/' . $fn);              
                    $images[] = $fn;                
                }                                
                
                include(SITE_ROOT . "/../view/captcha/captcha_view.php");

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                include(SITE_ROOT . "/../view/database_error.php");
            }
        }

        public function testCaptcha(): void
        {           
            $validate = new Validate();

            $phrase = strtolower($_POST['phrase']) ?? "";
            $captcha = strtolower($validate->test_input($_POST['captcha'])) ?? "";           

            try {
                if($phrase !== $captcha) throw new \Exception("Error Processing Captcha", 1);

                $_SESSION['user_name'] = "visiter";
                $_SESSION['role'] = "ROLE_USER";                
                $this->index();

            } catch (\Throwable $th) {
                $error_msg = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $error_msg = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }

                $this->message = $error_msg;
                $this->showCaptcha();
            }
        }
    }    
?>  