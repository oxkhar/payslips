<?php

namespace Tests\Infrastructure\Persistence;

use Payslip\Infrastructure\Persistence\FilePayslipReader;
use PHPUnit\Framework\TestCase;

class FilePayslipReaderTest extends TestCase
{

    /**
     * @test
     */
    public function it_parses_fields_with_payslip_info()
    {
        $expected = [
            "id"  => "000000000001",
            "vat" => "97084172E",
            "date" => "20191231",
            "gross" => "00248600",
            "insurance_rate" => "0500",
            "insurance_deduction" => "00012430",
            "tax_rate" => "1200",
            "taxes" => "00029832",
            "net" => "00206337",
        ];

        $fileReader = new FilePayslipReader(__DIR__.'/payslip_test_file');

        $fileReader->next();
        $payslip = $fileReader->current();

        self::assertEquals($expected, $payslip);
    }


}
