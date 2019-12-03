<?php declare(strict_types=1);

namespace Payslip\Domain;

interface PayslipRepository
{
    /**
     * @inheritDoc
     * @return Payslip[]
     */
    public function findByMonthAndYear(string $month, string $year): iterable;
}
