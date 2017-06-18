<?php
namespace DuktigSkeleton\Controller;

use PHPUnit\Framework\TestCase;
use Duktig\Core\AppFactory;
use Duktig\Core\App;
use Duktig\Http\Factory\Adapter\Guzzle\GuzzleServerRequestFactory;
use Duktig\Test\AppTesting;

class CallableRouteHandlerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app = (new AppFactory())->make(
            __DIR__.'/../../src/Config/config.php',
            AppTesting::class
        );
    }
    
    public function tearDown()
    {
        parent::tearDown();
        unset($this->app);
    }
    
    /**
     * Test without output buffering
     *
     * @disallowTestOutput
     */
    public function testGetsResponseFromRouteWithACallableHandler()
    {
        $request = $this->getRequest('/example-callable-handler');
        $this->app->run($request);
        $this->expectOutputRegex('/Response set by a callable route handler/');
    }
    
    private function getRequest($uri, $method = 'GET')
    {
        return (new GuzzleServerRequestFactory())->createServerRequest($method, $uri);
    }
}