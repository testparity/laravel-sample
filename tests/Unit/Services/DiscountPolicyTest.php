<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\DiscountPolicy;
use App\Services\InvoiceTotal;
use PHPUnit\Framework\TestCase;

final class DiscountPolicyTest extends TestCase
{
    public function test_applies_a_standard_discount(): void
    {
        $invoice = new InvoiceTotal;
        $subtotal = $invoice->quantityTotal(20, 5);

        self::assertSame(50, $invoice->splitPayments($subtotal, 2));
        self::assertSame(90.0, (new DiscountPolicy)->apply((float) $subtotal));
    }
}
