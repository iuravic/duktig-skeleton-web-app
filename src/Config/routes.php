<?php
/**
 * Your app's route definitions, see Core/routes.php.
 */
return [
    'landing-page' => [
        'path' => '{trailingSlash}',
        'params_defaults' => [],
        'params_requirements' => [
            'trailingSlash' => '/?',
        ],
        'handler' => \DuktigSkeleton\Controller\IndexController::class,
        'handler_method' => 'indexAction',
        'options' => [],
        'host' => '',
        'schemes' => [],
        'methods' => ['GET'],
        'middlewares' => [],
    ],
    'example-route-w-controller' => [
        'path' => '/example-controller-action/{myParam}',
        'params_defaults' => [],
        'params_requirements' => [
            'myParam' => '.*',
        ],
        'handler' => \DuktigSkeleton\Controller\IndexController::class,
        'handler_method' => 'renderAction',
        'options' => [],
        'host' => '',
        'schemes' => [],
        'methods' => ['GET'],
        'middlewares' => [
            \DuktigSkeleton\Middleware\ExampleGetIPRouteMiddleware::class,
        ],
    ],
    'example-ip-check' => [
        'path' => '/example-ip-check',
        'params_defaults' => [],
        'params_requirements' => [],
        'handler' => \DuktigSkeleton\Controller\IndexController::class,
        'handler_method' => 'checkIPAction',
        'options' => [],
        'host' => '',
        'schemes' => [],
        'methods' => ['GET'],
        'middlewares' => [],
    ],
    'example-route-with-callable-handler' => [
        'path' => '/example-callable-handler{trailingSlash}',
        'params_defaults' => [],
        'params_requirements' => [
            'trailingSlash' => '/?',
        ],
        'handler' => function (\Interop\Http\Factory\ResponseFactoryInterface $responseFactory) {
            $response = $responseFactory->createResponse();
            $response->getBody()->write('Response set by a callable route handler');
            return $response;
        },
        'handler_method' => null,
        'options' => [],
        'host' => '',
        'schemes' => [],
        'methods' => ['GET'],
        'middlewares' => [],
    ]
];