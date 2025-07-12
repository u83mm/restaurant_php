<?php

declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\Language;
use Application\model\classes\Query;
use Application\model\fpdf\FacturaPdf;

final class PrintBillController extends Controller 
{
    public function __construct(
        private Language $languageObject = new Language(),
        private object $dbcon = DB_CON, 
        private array $language = [],
        private string $message = "",
        private Query $query = new Query(),
    )
    {
        /** Configure page language */           
        $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();
    }

    public function print(): void
    {                
        try {
            global $id;

            // Check if the user is logged in and has the correct role
            $this->testAccess(['ROLE_ADMIN', 'ROLE_USER']);

            define('FPDF_FONTPATH', SITE_ROOT .'/../Application/model/fpdf/font');
            define('EURO_SIMBOL', chr(128));

            // Create a new PDF instance
            $pdf = new FacturaPdf();
            
            // Get the order from the database
            $order = $this->query->selectOneBy('orders', 'id', $id);
            
            if (!$order) {
                throw new \Exception("Order not found.");
            }

            // Set the PDF properties
            $pdf->title = ucwords($this->language['bill']);
            $pdf->SetAuthor("Restaurant");
            $pdf->SetCreator("Restaurant");
            $pdf->SetSubject(ucwords($this->language['bill']));

            $pdf->SetFillColor(0, 54.5, 54.5);           
            $pdf->AddPage();
            $pdf->AliasNbPages();                    
            $pdf->SetFont('GreatVibes','',15);

            // Set the invoice header
            $pdf->Cell(45, 8, iconv('UTF-8', 'ISO-8859-1', ucfirst($this->language['invoice_number'])) . " " . date('y') . "/{$id}", 0, 0, '', false);
            $pdf->Ln(10);  
            $pdf->Cell(20, 8, ucfirst($this->language['table']) . " " . $order['table_number'], 0, 0, '', false);
            $pdf->Cell(30, 8, ucfirst($this->language['people']) . " " . $order['people_qty'], 0, 0, 'C', false);
            $pdf->Cell(70, 8, "", 0, 0, 'C', false);
            $pdf->Cell(40, 8, ucfirst($this->language['date']) . " " . date('d-m-Y'), 0, 0, 'C', false);
            $pdf->Cell(30, 8, ucfirst($this->language['time']) . " " . date('H:i'), 0, 0, 'C', false);
            $pdf->Ln(10); 
            $pdf->Cell(0, 1, "", 0, 1, 'C', true);
            $pdf->SetFont('GreatVibes','',14);

            global $total;
            $total = 0; // Initialize total amount

            // Show the order items
            foreach ($order as $key => $value) {
                if(!in_array($key, ['aperitifs', 'firsts', 'seconds', 'desserts', 'drinks', 'coffees'])) {
                    continue; // Skip non-item fields
                }
                else {
                    if(empty($value) ||  empty($order[$key . '_qty'])) {
                        continue; // Skip empty items or those with zero quantity
                    }

                    // Build an array from the comma-separated values
                    $dishNameArray = explode(',', $value);
                    $dishQtyArray  = explode(',', $order[$key . '_qty']);
                    $dishIdArray   = explode(',', $order[$key . '_id']);                                        
                    
                    if(count($dishNameArray) >= 1) {
                        foreach ($dishNameArray as $dish_key => $dish_name) {
                            $price = $this->query->selectFieldsFromTableById(['price'], 'dishes', 'dishe_id', $dishIdArray[$dish_key]);
                            $pdf->Cell(60, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($dish_name)), 0, 0, 'L', false);
                            $pdf->Cell(30, 10, $dishQtyArray[$dish_key], 0, 0, 'C', false);
                            $pdf->Cell(30, 10, iconv('UTF-8', 'ISO-8859-1', $price['price']), 0, 0, 'L', false);
                            $pdf->Cell(65, 10, number_format(floatval($dishQtyArray[$dish_key]) * floatval($price['price']), 2, ',', '.') . " " . EURO_SIMBOL, 0, 1, 'R', false);

                            $total += floatval($order[$key . '_qty']) * floatval($price['price']);                            
                        }
                        
                        continue;
                    }

                    // Show the order item if it's not an array
                    $price = $this->query->selectFieldsFromTableById(['price'], 'dishes', 'dishe_id', $order[$key . '_id']);

                    $pdf->Cell(60, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($value)), 0, 0, 'L', false);
                    $pdf->Cell(30, 10, $order[$key . '_qty'], 0, 0, 'C', false);                    
                    $pdf->Cell(30, 10, iconv('UTF-8', 'ISO-8859-1', $price['price']), 0, 0, 'L', false);
                    $pdf->Cell(65, 10, number_format(floatval($order[$key . '_qty'])  * floatval($price['price']), 2, ',', '.') . " " . EURO_SIMBOL, 0, 1, 'R', false);
                    $total += floatval($order[$key . '_qty']) * floatval($price['price']);
                }
            }            
            
            $pdf->Output('', 'Factura.pdf', true);            
            
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
