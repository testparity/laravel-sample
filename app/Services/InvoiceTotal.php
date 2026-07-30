<?php

declare(strict_types=1);

namespace App\Services;

final class InvoiceTotal
{
    public function fromSubtotal(int $subtotal, int $tax): int
    {
        return $subtotal + $tax;
    }

    public function afterCredit(int $subtotal, int $credit): int
    {
        return $subtotal - $credit;
    }

    public function quantityTotal(int $unitPrice, int $quantity): int
    {
        return $unitPrice * $quantity;
    }

    public function splitPayments(int $total, int $payments): int
    {
        return intdiv($total, $payments);
    }

    public function withBuffer(int $subtotal, int $buffer): int
    {
        return $subtotal + $buffer;
    }
}
