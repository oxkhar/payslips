<?php declare(strict_types=1);

namespace Payslip\Application;

use Payslip\Domain\PayslipRepository;

class ListPayslipsAction
{
    /**
     * @var PayslipRepository
     */
    private $payslipRepository;

    public function __construct(PayslipRepository $payslipRepository)
    {
        $this->payslipRepository = $payslipRepository;
    }

    public function action(string $month, string $year): ActionResponse
    {
        $payslips = $this->payslipRepository->findByMonthAndYear($month, $year);

        return PayslipResponse::fromList($payslips);
    }
}
