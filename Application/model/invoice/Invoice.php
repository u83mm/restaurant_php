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
    ) {
        // Constructor logic if needed
    }
    public function getTotal(float $iva, float $neto): float
    {
        return round(($neto * $iva) + $neto, 2);
    }

    public function getNeto(float $qty, float $price): float
    {
        return round($qty * $price, 2);
    }
}
