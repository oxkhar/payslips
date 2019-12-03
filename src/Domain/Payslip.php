<?php declare(strict_types=1);

namespace Payslip\Domain;

class Payslip
{
    private $payslipId;
    private $vat;
    private $date;
    private $gross;
    private $insuranceRate;
    private $insuranceDeductions;
    private $taxRate;
    private $taxes;
    private $net;

    public function __construct(
        string $payslipId,
        string $vat,
        \DateTimeImmutable $date,
        float $gross,
        float $insuranceRate,
        float $insuranceDeductions,
        float $taxRate,
        float $taxes,
        float $net
    ) {
        $this->payslipId = $payslipId;
        $this->vat = $vat;
        $this->date = $date;
        $this->gross = $gross;
        $this->insuranceRate = $insuranceRate;
        $this->insuranceDeductions = $insuranceDeductions;
        $this->taxRate = $taxRate;
        $this->taxes = $taxes;
        $this->net = $net;
    }

    public function payslipId(): string
    {
        return $this->payslipId;
    }

    public function vat(): string
    {
        return $this->vat;
    }

    public function date(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function gross(): float
    {
        return $this->gross;
    }

    public function insuranceRate(): float
    {
        return $this->insuranceRate;
    }

    public function insuranceDeductions(): float
    {
        return $this->insuranceDeductions;
    }

    public function taxRate(): float
    {
        return $this->taxRate;
    }

    public function taxes(): float
    {
        return $this->taxes;
    }

    public function net(): float
    {
        return $this->net;
    }

    public function modifyTaxRate(float $taxRate): self
    {
        $taxes = round($this->gross * $taxRate / 100.0, 2);
        return new static(
            $this->payslipId,
            $this->vat,
            $this->date,
            $this->gross,
            $this->insuranceRate,
            $this->insuranceDeductions,
            $taxRate,
            $taxes,
            round($this->gross - $this->insuranceDeductions - $taxes, 2)
        );
    }
}
