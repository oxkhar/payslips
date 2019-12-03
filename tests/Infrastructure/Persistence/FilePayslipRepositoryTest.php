<?php

namespace Tests\Infrastructure\Persistence;

use Payslip\Infrastructure\Persistence\FilePayslipRepository;
use Tests\TestCase;

class FilePayslipRepositoryTest extends TestCase
{

    /**
     * @test
     */
    public function it_finds_by_month_and_year()
    {
        $year = '2019';
        $month = '11';

        $repo = new FilePayslipRepository(__DIR__.'/payslip_test_file');

        $payslips = $repo->findByMonthAndYear($month, $year);

        self::assertNotEmpty($payslips);
        foreach ($payslips as $payslip) {
            self::assertEquals($year.$month, $payslip->date()->format('Ym'));
        }
    }
}
