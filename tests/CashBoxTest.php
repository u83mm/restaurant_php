<?php

declare(strict_types=1);

use Application\Controller\admin\CashBoxController;
use Application\Core\Controller;
use Application\model\classes\App;
use Application\model\classes\Language;
use Application\model\classes\Query;
use Application\model\classes\Validate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
#[CoversClass("CashBoxController")]
final class CashBoxTest extends TestCase
{
    protected ?App $app                 = null;
    protected ?Validate $validate       = null;
    protected ?Controller $controller   = null;
    protected ?Query $query             = null;
    protected ?Language $languageObject = null;
    protected ?array $language          = null;

    protected function setUp(): void
    {
        define('SITE_ROOT', '/var/www/public');        
        define('DB_CONFIG_FILE', SITE_ROOT . '/../Application/db_test.config.php');                      	
        require_once(SITE_ROOT . "/../Application/connect.php");                               
        define('DB_CON', $dbcon);

        $this->app            = new App();
        $this->validate       = new Validate();
        $this->controller     = new Controller();
        $this->query          = new Query();
        $this->languageObject = new Language();
        $this->language       = $this->languageObject->spanish(); // Load the Spanish language dictionary
    }

    public function testCashBoxFunctionality(): void
    {
        # Setup the environment for the test
        $_SESSION['user_name'] = "admin";
        $_SESSION['role'] = "ROLE_ADMIN";
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/admin/cashBox/index/2'; // Simulate a GET request to the cash box index
        $_SESSION['language'] = 'spanish'; // Set the language to Spanish

        global $id;
        $total = 0;

        # Run the logic to be tested
        $testAccess = $this->controller->testAccess(['ROLE_ADMIN', 'ROLE_USER']);

        // Load the Cash Box view
        ob_start();
        $this->app->router();
        $html = ob_get_contents();
        ob_end_clean();

        // Reset the request method and URI for the next test
        $_SERVER['REQUEST_METHOD'] = 'POST'; // Reset request method for next tests
        $_SERVER['REQUEST_URI'] = '/admin/cashBox/index/' . $id; // Reset request URI for next tests

        // Simulate a total amount for the cash box
        $total = 100; // Simulate a total amount for the cash box
        $cashAmount = 150; // Simulate a cash amount provided by the user
        $paymentMethodId = 2; // Simulate a payment method ID

        // Calculate the change based on the total amount and cash amount
        $cashBoxController = new CashBoxController();
        $change = $cashBoxController->calculateOrderTransaction($total, $cashAmount, $paymentMethodId);

        # Clean up the environment after the test
        unset($_SESSION['user_name']);
        unset($_SESSION['role']);
        unset($_SESSION['language']);
        unset($_SERVER['REQUEST_METHOD']);
        unset($_SERVER['REQUEST_URI']);

        # Assertions to verify the expected outcome
        $this->assertFileExists('Application/view/admin/cashbox/main_view.php');
        $this->assertStringContainsString('My Restaurant | Cash Box', $html);
        $this->assertStringContainsString('CAJA', $html);
        $this->assertTrue($testAccess, 'Access control failed'); // Ensure access control is working
        $this->assertNotEquals(0, $total, 'Total amount should not be zero'); // Ensure total amount is calculated
        $this->assertEquals(50, $change, 'Change should be 50 when total is 100 and cash amount is 150');
    }

    public function testFinishOrderFunctionality(): void
    {
        # Setup the environment for the test
        $_SESSION['user_name'] = "admin";
        $_SESSION['role'] = "ROLE_ADMIN";
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/admin/cashBox/index/2'; // Simulate a GET request to the cash box index
        $_SESSION['language'] = 'spanish'; // Set the language to Spanish        

        global $id;

        # Run the logic to be tested
        $testAccess = $this->controller->testAccess(['ROLE_ADMIN', 'ROLE_USER']);

        // Load the Cash Box view
        ob_start();
        $this->app->router();
        $html = ob_get_contents();
        ob_end_clean();

        // Reset the request method and URI for the next test
        $_SERVER['REQUEST_METHOD'] = 'GET'; // Reset request method for next tests
        $_SERVER['REQUEST_URI'] = '/admin/cashBox/finishOrder/' . $id; // Reset request URI for next tests

        $this->app = new App();
        $this->app->router();

        // Reset the request method and URI for the next test
        $_SERVER['REQUEST_METHOD'] = 'GET'; // Reset request method for next tests
        $_SERVER['REQUEST_URI'] = '/admin/comandas/index/' . $id; // Reset request URI for next tests

        $this->app = new App();        

        ob_start();
        $this->app->router();
        $finish = ob_get_contents();
        ob_end_clean();

        # Clean up the environment after the test
        unset($_SESSION['user_name']);
        unset($_SESSION['role']);
        unset($_SESSION['language']);
        unset($_SERVER['REQUEST_METHOD']);
        unset($_SERVER['REQUEST_URI']);

        # Assertions to verify the expected outcome
        $this->assertFileExists('Application/view/admin/cashbox/main_view.php');
        $this->assertStringContainsString('My Restaurant | Cash Box', $html);
        $this->assertStringContainsString('CAJA', $html);
        $this->assertTrue($testAccess, 'Access control failed');
        $this->assertStringContainsString('Pedido finalizado', $finish);
    }

    protected function tearDown(): void
    {
        // Clean up after tests if necessary
        unset($this->app);
        unset($this->validate);
        unset($this->controller);
        unset($this->query);
        unset($this->languageObject);
        unset($this->language);
    }
}
