<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\InvoiceTotal;
use PHPUnit\Framework\TestCase;

final class InvoiceTotalTest extends TestCase
{
    public function test_covers_the_core_invoice_operations(): void
    {
        $invoice = new InvoiceTotal;

        self::assertSame(125, $invoice->fromSubtotal(100, 25));
        self::assertSame(90, $invoice->afterCredit(100, 10));
    }
}
