<?php
    declare(strict_types=1);

    namespace Application\Controller;

    use Application\Core\Controller;
    use Application\model\captcha\SingleChar;
    use Application\model\captcha\Strategy\{LineFill,DotFill,Shadow,RotateText};
    use Application\model\classes\QueryMenu;
    use Application\model\classes\Validate;

    class IndexController extends Controller
    {
        public function __construct(
            private string $message = "",
            private QueryMenu $menuDayQuery = new QueryMenu()
        )
        {                        
        }

      /**
       * This function selects dishes of the day and calculates the menu's day price before including
       * the main view.
       */
        public function index(): void
        {    
            if(!isset($_SESSION['role'])) header("Location: /index/showCaptcha");

            try {                                                                                                                                                
                /** Get dishes, dessert and price to show in the Day's menu aside section */
                $menuDaySections = $this->menuDayQuery->getMenuDayElements();                                            
                                                                        
                $this->render("/view/main_view.php", [
                    'menuDaySections'   =>  $menuDaySections
                ]);                

            } catch (\Throwable $th) {
                $message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    'message'   =>  $message
                ]);
            }
        }

        public function showCaptcha():void
        {                                                            
            if(isset($_SESSION['role'])) header("Location: /");
            
            $_SESSION['user_name'] = "";

            define('NUM_BYTES', 3);
            define('FONT_FILE', SITE_ROOT . '/ttf/FreeSansBold.ttf');
            define('IMG_DIR', SITE_ROOT . '/images/captcha');

            $strategies = ['rotate', 'line', 'line','dot', 'dot', 'shadow']; 

            $phrase = strtoupper(bin2hex(random_bytes(NUM_BYTES)));            
            $length = strlen($phrase);
            $images = [];        

            try {
                for($x = 0; $x < $length; $x++) {
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
                                
                $this->render("/view/captcha/captcha_view.php", [
                    'images'    =>  $images,
                    'phrase'    =>  $phrase,
                    'message'   =>  $this->message
                ]);

            } catch (\Throwable $th) {
                $message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
                
                $this->render("/view/database_error.php", [
                    'message'   =>  $message
                ]);
            }
        }

        public function testCaptcha(): void
        {           
            $validate = new Validate();

            $phrase = isset($_POST['phrase']) ? strtolower($_POST['phrase']) : "";
            $captcha = isset($_POST['captcha']) ? strtolower($validate->test_input($_POST['captcha'])) : "";           

            try {
                if(!$validate->validate_form(['captcha' => $captcha])) {
                    $this->message = $validate->get_msg();
                    $this->showCaptcha();                    
                }                
                elseif(empty($phrase) || $phrase !== $captcha) throw new \Exception("Error Processing Captcha", 1);
                else {
                    $_SESSION['user_name'] = "visiter";
                    $_SESSION['role'] = "ROLE_USER"; 
                    unset($_SESSION['message']);                                  
                    header("Location: /");
                }
                
            } catch (\Throwable $th) {
                $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

                if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                    $this->message = "<p class='alert alert-danger text-center'>
                                    Message: {$th->getMessage()}<br>
                                    Path: {$th->getFile()}<br>
                                    Line: {$th->getLine()}
                                </p>";
                }
               
                $this->showCaptcha();
            }
        }
    }    
?>