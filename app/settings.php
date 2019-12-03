<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'payslip' => [
                'file' => dirname(__DIR__).'/var/data/payslip.dat'
            ]

        ],
    ]);
};
