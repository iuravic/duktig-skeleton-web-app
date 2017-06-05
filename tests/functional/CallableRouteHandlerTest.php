<?php
namespace DuktigSkeleton\Controller;

use PHPUnit\Framework\TestCase;
use Duktig\Core\AppFactory;
use Duktig\Core\App;
use Duktig\Http\Factory\Adapter\Guzzle\GuzzleServerRequestFactory;

class CallableRouteHandlerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app = (new AppFactory())->make(
            __DIR__.'/../../src/Config/config.php',
            App::class
        );
    }
    
    public function tearDown()
    {
        parent::tearDown();
        unset($this->app);
    }
    
    public function testGetsResponseFromRouteWithACallableHandler()
    {
        $request = $this->getRequest('/example-callable-handler');
        $this->app->run($request);
        $html = $this->app->getResponse()->getBody()->__toString();
        $this->assertContains('Response set by a callable route handler', $html,
            "Response body does not contain the expected expression"
        );
    }
    
    private function getRequest($uri, $method = 'GET')
    {
        return (new GuzzleServerRequestFactory())->createServerRequest($method, $uri);
    }
}