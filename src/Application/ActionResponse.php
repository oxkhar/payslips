<?php declare(strict_types=1);

namespace Payslip\Application;

class ActionResponse implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data;

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        return $this->data;
    }

}
