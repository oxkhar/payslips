<?php declare(strict_types=1);

namespace Payslip\Application;

use Payslip\Domain\PayslipRepository;

class ModifyTaxRateAction
{
    /**
     * @var PayslipRepository
     */
    private $payslipRepository;

    public function __construct(PayslipRepository $payslipRepository)
    {
        $this->payslipRepository = $payslipRepository;
    }

    public function action(string $month, string $year, float $taxRate): ActionResponse
    {
        $response = [];

        $payslips = $this->payslipRepository->findByMonthAndYear($month, $year);
        foreach ($payslips as $payslip) {
            $response[]  = $payslip->modifyTaxRate($taxRate);
        }

        return PayslipResponse::fromList($response);
    }
}
