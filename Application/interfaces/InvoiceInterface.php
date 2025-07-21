<?php

declare(strict_types=1);

namespace Application\interfaces;

interface InvoiceInterface
{
    public function getTotal(float $neto): float;

    public function getNeto(float $qty, float $price): float;
}
