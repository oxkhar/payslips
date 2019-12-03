<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            \Payslip\Domain\PayslipRepository::class => function (ContainerInterface $c) {
                $settings = $c->get('settings');

                return new \Payslip\Infrastructure\Persistence\FilePayslipRepository($settings['payslip']['file']);
            },
        ]
    );
};
