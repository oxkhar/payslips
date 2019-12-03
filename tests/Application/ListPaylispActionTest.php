<?php
declare(strict_types=1);

namespace Tests\Application;

use DI\Container;
use Payslip\Application\PayslipResponse;
use Payslip\Domain\Payslip;
use Payslip\Domain\PayslipRepository;
use Tests\TestCase;

class ListPaylispActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_lists_of_payslips_by_month()
    {
        $app = $this->getAppInstance();
        /** @var Container $container */
        $container = $app->getContainer();

        $payslips = [
            new Payslip(
                "123456789012",
                '123456789',
                \DateTimeImmutable::createFromFormat('Ymd', "20191112"),
                123456.78,
                12.33,
                876543.21,
                43.21,
                666666.22,
                987654.12
            ),
            new Payslip(
                "123123123344",
                '345345343',
                \DateTimeImmutable::createFromFormat('Ymd', "20191107"),
                442431.34,
                14.55,
                145663.25,
                74.24,
                553223.41,
                145454.52
            ),
        ];

        $year = '2019';
        $month = '11';

        $userRepositoryProphecy = $this->prophesize(PayslipRepository::class);
        $userRepositoryProphecy
            ->findByMonthAndYear($month, $year)
            ->willReturn($payslips)
            ->shouldBeCalledOnce();

        $container->set(PayslipRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/payslips', "month=".$month."&year=".$year."");
        $response = $app->handle($request);
        $payload = (string)$response->getBody();

        $serializedPayload = json_encode(PayslipResponse::fromList($payslips), JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($serializedPayload, $payload);
    }
}
