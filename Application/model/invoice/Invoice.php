<?php

declare(strict_types=1);

namespace Application\model\invoice;

use Application\Core\Controller;
use Application\interfaces\InvoiceInterface;
use Application\model\classes\Query;

final class Invoice extends Controller implements InvoiceInterface
{
    public function __construct(
        private object $Query = new Query(),
        private float $total = 0.0,
        private float $neto = 0.0,        
    ) {
        // Constructor logic if needed
    }
    public function getTotal(float $neto): float
    {
        return $this->total = round(($neto * IVA) + $neto, 2); // Calculate total including IVA
    }

    public function getNeto(float $qty, float $price): float
    {
        return $this->neto = round($qty * $price, 2); // Calculate neto from quantity and price
    }
}
