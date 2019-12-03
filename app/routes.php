<?php
declare(strict_types=1);

use Payslip\Application\ListPayslipsAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get(
        '/payslips',
        function (Request $request, Response $response) {
            $params = $request->getQueryParams();

            $actionResponse = $this
                ->get(ListPayslipsAction::class)
                ->action($params['month'], $params['year']);

            $json = json_encode($actionResponse, JSON_PRETTY_PRINT);
            $response->getBody()->write($json);

            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json');
        }
    );

    $app->put(
        '/payslips',
        function (Request $request, Response $response) {
            $params = json_decode($request->getBody()->getContents(), true);

            $actionResponse = $this
                ->get(\Payslip\Application\ModifyTaxRateAction::class)
                ->action($params['month'], $params['year'], (float)$params['tax_rate']);

            $json = json_encode($actionResponse, JSON_PRETTY_PRINT);
            $response->getBody()->write($json);

            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json');
        }
    );
};
