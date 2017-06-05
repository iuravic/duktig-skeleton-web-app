<?php
namespace DuktigSkeleton\Middleware;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use DuktigSkeleton\Service\ExampleIPService;

/**
 * An example middleware, which is assigned to a specific route. It uses the
 * ExampleIPService as a dependency, gets the client's IP from it, and embedds
 * this IP into the request as an attribute.
 */
class ExampleGetIPRouteMiddleware implements MiddlewareInterface
{
    private $ipService;
    
    public function __construct(ExampleIPService $ipService)
    {
        $this->ipService = $ipService;
    }
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $request = $request->withAttribute('clientIP', $this->ipService->getClientIP());
        return $delegate->process($request);
    }
}