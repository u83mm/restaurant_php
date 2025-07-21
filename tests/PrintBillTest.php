<?php

declare(strict_types=1);

use Application\Controller\admin\PrintBillController;
use Application\Core\Controller;
use Application\model\classes\App;
use Application\model\classes\Language;
use Application\model\classes\Query;
use Application\model\classes\Validate;
use Application\model\invoice\Invoice;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * PrintBillTest
 *
 * This class tests the functionality of printing a bill in the application.
 * It sets up the necessary environment and checks if the bill can be printed correctly.
 */
#[CoversClass(PrintBillController::class)]
final class PrintBillTest extends TestCase
{
    protected ?App $app                 = null;
    protected ?Validate $validate       = null;
    protected ?Controller $controller   = null;
    protected ?Query $query             = null;
    protected ?Language $languageObject = null;
    protected ?array $language          = null;
    protected ?Invoice $invoice         = null;

    // This method is called before each test. It contains the code necessary to set up the test environment.
    protected function setUp(): void
    {                
        define('SITE_ROOT', '/var/www/public');        
        define('DB_CONFIG_FILE', SITE_ROOT . '/../Application/db_test.config.php');                      	
        require_once(SITE_ROOT . "/../Application/connect.php");                               
        define('DB_CON', $dbcon);
        define('IVA', 0.21);

        $this->app            = new App();
        $this->validate       = new Validate();
        $this->controller     = new Controller();
        $this->query          = new Query();
        $this->languageObject = new Language();
        $this->language       = $this->languageObject->spanish(); // Load the Spanish language dictionary
        $this->invoice        = new Invoice();
    }

    public function testPrintBill(): void
    {
        # Setup the environment for the test
        $_SESSION['user_name'] = "admin";
        $_SESSION['role'] = "ROLE_ADMIN";
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/admin/comandas/show';
        $_SESSION['id'] = $_POST['id'] = 2; // Simulate a POST request with an ID
        $_SESSION['language'] = 'spanish'; // Set the language to Spanish

        global $id;
        global $saved;
        $id = $_SESSION['id'];
        $saved = false;
      
        # Run the logic to be tested
        // Load the Order view
        ob_start();
        $this->app->router();
        $html = ob_get_contents();
        ob_end_clean();        

        // Call the printBill method to generate the PDF        
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/admin/printBill/print/'.$id;

        $this->app = new App();
        
        ob_start();
        $this->app->router();
        $pdfOutput = ob_get_contents();
        ob_end_clean();

        // Get total invoice
        $neto = $this->invoice->getNeto(10, 35.00); // Example quantity and price
        $total = $this->invoice->getTotal($neto); // Example neto value                      

        # Clean up the environment after the test
        unset($_SESSION['user_name']);
        unset($_SESSION['role']);
        unset($_SERVER['REQUEST_METHOD']);
        unset($_SERVER['REQUEST_URI']);
        unset($_SESSION['id']);
        unset($_SESSION['language']);

        # Assertions to verify the expected outcome
        $this->assertFileExists('Application/view/admin/comandas/show_view.php');
        $this->assertStringContainsString('Imprimir Factura', $html);        
        $this->assertStringContainsString('Restaurant', $pdfOutput);
        $this->assertStringContainsString('Factura', $pdfOutput);
        $this->assertEquals(423.50, $total); // Example order array
        $this->assertTrue($saved, 'Invoice should be saved successfully');
    }
}
