<?php
namespace DuktigSkeleton\Middleware;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

/**
 * An example application middleware, which is run on each and every request.
 * It appends a comment to the response body. 
 */
class ExampleAppMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = $delegate->process($request);
        $response->getBody()->write('<!-- appended by app-wide middleware -->');
        return $response;
    }
}