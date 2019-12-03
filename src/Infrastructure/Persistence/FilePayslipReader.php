<?php declare(strict_types=1);

namespace Payslip\Infrastructure\Persistence;

class FilePayslipReader extends \IteratorIterator
{
    public function __construct(string $pathFile)
    {
        parent::__construct(new \SplFileObject($pathFile));
    }

    public function current()
    {
        return $this->parse(parent::current());
    }

    private function parse($current)
    {
        return [
            'id'                  => substr($current, 0, 12),
            'vat'                 => substr($current, 12, 9),
            'date'                => substr($current, 21, 8),
            'gross'               => substr($current, 29, 8),
            'insurance_rate'      => substr($current, 37, 4),
            'insurance_deduction' => substr($current, 41, 8),
            'tax_rate'            => substr($current, 49, 4),
            'taxes'               => substr($current, 53, 8),
            'net'                 => substr($current, 61, 8),
        ];
    }
}
