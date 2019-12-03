<?php
declare(strict_types=1);

namespace Tests\Application;

use DI\Container;
use Payslip\Application\PayslipResponse;
use Payslip\Domain\Payslip;
use Payslip\Domain\PayslipRepository;
use Tests\TestCase;

class ModifyTaxRateActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_modifies_tax_rate_for_payslips_in_year_and_month_recalculating_taxes_and_nets()
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();

        $fixtures = [
            new Payslip(
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                100000,
                5,
                5000,
                10,
                10000,
                85000
            ),
            new Payslip(
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                12345678.91,
                13,
                1604938.26,
                27,
                3333333.31,
                7407407.34
            ),
        ];

        $year = '2019';
        $month = '11';
        $taxRate = 17;

        $userRepositoryProphecy = $this->prophesize(PayslipRepository::class);
        $userRepositoryProphecy
            ->findByMonthAndYear($month, $year)
            ->willReturn($fixtures)
            ->shouldBeCalledOnce();

        $container->set(PayslipRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('PUT', '/payslips');
        $j = json_encode(["year" => $year, "month" => $month, "tax_rate" => $taxRate]);
        $request->getBody()->write($j);
        $request->getBody()->rewind();

        $response = $app->handle($request);
        $payload = (string)$response->getBody();


        $expected = [
            new Payslip(
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                100000,
                5,
                5000,
                17,
                17000,
                78000
            ),
            new Payslip(
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                12345678.91,
                13,
                1604938.26,
                17,
                2098765.41,
                8641975.24
            ),
        ];

        $serializedPayload = json_encode(PayslipResponse::fromList($expected), JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($serializedPayload, $payload);
    }
}
