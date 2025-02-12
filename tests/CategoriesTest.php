<?php
declare(strict_types=1);

use Application\Controller\admin\CategoriesController;
use Application\Controller\IndexController;
use Application\model\classes\App;
use Application\model\classes\Validate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CategoriesController::class)]
class CategoriesTest extends TestCase
{
    protected App $app;
    protected Validate $validate;    
    
    // This method is called before each test. It contains the code necessary to set up the test environment.
    protected function setUp(): void
    {        
        $this->app = new App();
        $this->validate = new Validate();

        define('SITE_ROOT', '/var/www/public');        
        define('DB_CONFIG_FILE', SITE_ROOT . '/../Application/db.config.php');                      	
        require_once(SITE_ROOT . "/../Application/connect.php");               
                
        define('DB_CON', $dbcon);
    }

    public function testIsLoadedCaptcha(): void
    {
        ob_start();

        $_SESSION['user_name'] = "visiter";
        $_SESSION['role'] = "ROLE_USER";
        
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';        

        $this->app->router();
        //$this->app = new App();

        /* $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/index/showCaptcha';

        $this->app->router(); */

        $html = ob_get_contents();        

        ob_end_clean();
        
        $this->assertFileExists('Application/view/login_view.php');
        $this->assertStringContainsString('Bienvenido', $html);
    }
    
    public function testIsLoadedCategoriesIndex(): void
    {
        # Send login request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI']    = '/login';

        $_POST['email']    = 'admin@admin.com';
        $_POST['password'] = 'admin';
        $_POST['csrf_token']  = $_SESSION['csrf_token'] = $this->validate->csrf_token();

        $this->app->router(); 
        
        $this->app = new App();

        ob_start();
        
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/admin/categories/index';

        $this->app->router();

        $html = ob_get_contents();        

        ob_end_clean();
        
        $this->assertFileExists('Application/view/admin/categories/index.php');
        $this->assertStringContainsString('My Restaurant | Categories', $html);
    }
}
