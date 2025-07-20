<?php

declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\Language;
use Application\model\classes\Query;
use Application\model\classes\Validate;

final class CashBoxController extends Controller
{
    public function __construct(
        private Language $languageObject = new Language(),
        private object $dbcon = DB_CON,
        private array $language = [],
        private string $message = "",
        private Query $query = new Query(),
        private Validate $validate = new Validate(),
        private array $fields = [],
    ) {
        /** Configure page language */
        $this->language = $_SESSION['language'] == "spanish" ? (new Language())->spanish() : (new Language())->english();
    }
    /**
     * Index method to load the main view of the cash box.
     *
     * @param int $orderId The ID of the order for which the cash box is being accessed.
     */
    public function index(): void
    {
        try {
            // Check if the user is logged in and has the correct role
            $this->testAccess(['ROLE_ADMIN', 'ROLE_USER']);

            // Get the invoice details for the specified order ID
            global $id;
            $invoice = $this->query->selectOneBy('invoices', 'order_id', $id);
            $total = floatval($invoice['total_amount']) ?? 0;

            // Set the fields for the view
            $this->fields = [
                'total'           => $total,                
                'csrf_token'      => $this->validate,
                'payment_methods' => $this->query->selectAll('payment_method'),
                'order_id'        => $id       
            ];           

            // If the request method is POST, process the cash amount and calculate change
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cash_amount'])) {
                $cashAmount = floatval($this->validate->test_input($_POST['cash_amount']) ?? 0);
                $this->fields['payment_method'] = intval($this->validate->test_input($_POST['payment_method'])) ?? null; 

                if(!$this->validate->validate_form(['payment method' => $this->fields['payment_method']])) {
                    $_SESSION['message'] = "<p class='alert alert-danger text-center'>{$this->validate->get_msg()}</p>";
                }                                                         
                else if(is_float($cashAmount) && $this->validate->validate_csrf_token()) {
                    $this->fields['change'] = $this->calculateOrderTransaction($total, $cashAmount, $this->fields['payment_method']);
                    $this->fields['cash_amount'] = $cashAmount;                         
                }   
                else {
                    $_SESSION['message'] = !is_float($cashAmount) ? 
                                                    "<p class='alert alert-danger text-center'>Invalid cash amount</p>" : 
                                                    "<p class='alert alert-danger text-center'>Invalid csrf_token</p>";
                }
                            
            }

            // Render the main view of the cash box
            $this->render("/view/admin/cashbox/main_view.php", $this->fields);

        } catch (\Throwable $th) {
            $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $this->message = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }

            $this->render("/view/database_error.php", [
                'message' => $this->message
            ]);
        }
    }

    public function calculateOrderTransaction(float $totalAmount, float $cashAmount, int $paymentMethodId): float
    {
        global $id;

        // Calculate the transaction details based on the total amount, cash amount, and return amount
        $change = $cashAmount - $totalAmount;
        if ($change < 0) {
            // If the cash amount is less than the total, set change to 0 and return an error message
            $_SESSION['message'] = "<p class='alert alert-danger text-center'>Insufficient cash provided.</p>";
            return 0.0;
        }

        // If the cash amount is sufficient, return the change and update invoices
        $this->query->updateRegistry(
            'invoices', 
            [
                'returned_amount'   => $change, 
                'payment_method_id' => $paymentMethodId, 
                'invoice_status'    => 'paid', 
                'given_amount'      => $cashAmount,
                'order_id'          => $id
            ], 
            'order_id'
        );        

        return $change;
    }

    public function finishOrder(): void 
    {
        // Check if the user is logged in and has the correct role
        $this->testAccess(['ROLE_ADMIN', 'ROLE_USER']);

        // Set the invoice status to 'finished' for the specified order ID        
        global $id;        

        try {
            // Test if invoice is payed
            $invoice = $this->query->selectFieldsFromTableById(['invoice_status'], 'invoices', 'order_id', $id);
            
            if($invoice['invoice_status'] !== 'paid') {
                $_SESSION['message'] = "<p class='alert alert-danger text-center'>{$this->language['table_pending_collection']}</p>";
                header("Location: /admin/cashBox/index/$id");
                return;
            }

            if(!$this->query->updateRegistry('orders', ['finished' => 1, 'id' => $id], 'id')) {
                $_SESSION['message'] = "<p class='alert alert-danger text-center'>{$this->language['error_finished_order']}</p>";
            }
            else {
                $_SESSION['message'] = "<p class='alert alert-success text-center'>{$this->language['order_finished_successfully']}</p>";
            }
            
            header("Location: /admin/comandas/index");

        } catch (\Throwable $th) {
            $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $this->message = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }

            $this->render("/view/database_error.php", [
                'message' => $this->message
            ]);
        }
    }
}
