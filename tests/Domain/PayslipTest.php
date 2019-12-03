<?php declare(strict_types=1);

namespace Tests\Domain;

use Payslip\Domain\Payslip;
use Tests\TestCase;

class PayslipTest extends TestCase
{
    public function payslipProvider()
    {
        return [
            [
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                123456.78,
                12.34,
                876543.21,
                43.21,
                666666.22,
                987654.12,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider payslipProvider
     */
    public function it_defines_payslip_properties(
        $id,
        $vat,
        $date,
        $gross,
        $insuranceRate,
        $insuranceDeductions,
        $taxRate,
        $taxes,
        $net
    ) {
        $payslip = new Payslip($id, $vat, $date, $gross, $insuranceRate, $insuranceDeductions, $taxRate, $taxes, $net);

        self::assertEquals($id, $payslip->payslipId());
        self::assertEquals($vat, $payslip->vat());
        self::assertEquals($date, $payslip->date());
        self::assertEquals($gross, $payslip->gross());
        self::assertEquals($insuranceDeductions, $payslip->insuranceDeductions());
        self::assertEquals($insuranceRate, $payslip->insurancerate());
        self::assertEquals($taxRate, $payslip->taxRate());
        self::assertEquals($taxes, $payslip->taxes());
        self::assertEquals($net, $payslip->net());
    }
}
