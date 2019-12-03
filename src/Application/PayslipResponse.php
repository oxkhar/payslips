<?php declare(strict_types=1);

namespace Payslip\Application;

use Payslip\Domain\Payslip;

class PayslipResponse extends ActionResponse
{
    public static function from(Payslip $payslip)
    {
        return new static(
            [
                'payslip_id'           => $payslip->payslipId(),
                'vat'                  => $payslip->vat(),
                'date'                 => $payslip->date()->format('Y-m-d'),
                'gross'                => $payslip->gross(),
                'insurance_rate'       => $payslip->insuranceRate(),
                'insurance_deductions' => $payslip->insuranceDeductions(),
                'tax_rate'             => $payslip->taxRate(),
                'taxes'                => $payslip->taxes(),
                'net'                  => $payslip->net(),
            ]
        );
    }

    public static function fromList($payslips)
    {
        $response = [];
        foreach ($payslips as $payslip) {
            $response[] = static::from($payslip);
        }
        return new static($response);
    }
}
