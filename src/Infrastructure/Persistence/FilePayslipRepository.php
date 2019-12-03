<?php declare(strict_types=1);

namespace Payslip\Infrastructure\Persistence;

use Iterator;
use Payslip\Domain\Payslip;
use Payslip\Domain\PayslipRepository;

class FilePayslipRepository implements PayslipRepository
{
    /**
     * @var \IteratorIterator
     */
    private $file;

    public function __construct(string $file)
    {
        $this->file = new class(new FilePayslipReader($file)) extends \IteratorIterator {
            public function current()
            {
                $ps = parent::current();

                return new Payslip(
                    $ps['id'],
                    $ps['vat'],
                    \DateTimeImmutable::createFromFormat('YmdHis', $ps['date'].'000000'),
                    $ps['gross'] / 100.0,
                    $ps['insurance_rate'] / 100.0,
                    $ps['insurance_deduction'] / 100.0,
                    $ps['tax_rate'] / 100.0,
                    $ps['taxes'] / 100.0,
                    $ps['net'] / 100.0
                );
            }
        };
    }

    /**
     * @return Payslip[]
     */
    public function findByMonthAndYear(string $month, string $year): iterable
    {
        return (new class($this->file, $year.$month) extends \FilterIterator {
            private $yearMonth;

            public function __construct(Iterator $iterator, $yearMonth)
            {
                parent::__construct($iterator);
                $this->yearMonth = $yearMonth;
            }

            public function accept()
            {
                return $this->current()->date()->format('Ym') === $this->yearMonth;
            }
        });
    }
}
