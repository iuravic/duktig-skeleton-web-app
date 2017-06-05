<?php
namespace DuktigSkeleton\Controller;

use PHPUnit\Framework\TestCase;
use Duktig\Core\AppFactory;
use Duktig\Test\AppTesting;
use Duktig\Http\Factory\Adapter\Guzzle\GuzzleServerRequestFactory;

class IndexControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->app = (new AppFactory())->make(
            __DIR__.'/../../../src/Config/config.php',
            AppTesting::class
        );
    }
    
    public function tearDown()
    {
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }
        \Mockery::close();
        unset($this->app);
    }
    
    public function testGetsResponseFromRouteWithControllerAndDI()
    {
        $response = $this->getResponseFromRoute('/example-controller-action/uri-param-name');
        $html = $response->getBody()->__toString();
        $this->assertEquals(200, $response->getStatusCode(),
            "Response does not have the expected status code");
        $this->assertRegExp("/.*<title>.*Sample page indexAction.*<\/p>.*/s", $html,
            "Response body does not contain the expected expression");
        $this->assertRegExp("/.*<p>URI params.*uri-param-name.*<\/p>.*/s", $html,
            "Response body does not contain the expected expression");
    }
    
    public function testResponseBodyChangedByApplicationMiddleware()
    {
        $response = $this->getResponseFromRoute('/example-controller-action/uri-param-name');
        $this->assertContains('<!-- appended by app-wide middleware -->',
            $response->getBody()->__toString(),
            "Response body does not contain the expected expression"
        );
    }
    
    public function testRequestModifiedByRouteSpecificMiddleware()
    {
        $this->mockExampleIPService([
            ['shouldReceive' => 'getClientIP', 'andReturn' => '176.64.10.11']
        ]);
        
        $request = $this->getRequest('/example-controller-action/uri-param-name');
        $response = $this->app->run($request)->getResponse();
        $this->assertContains('clientIP: 176.64.10.11',
            $response->getBody()->__toString(),
            "Response body does not contain the expected expression"
        );
    }
    
    public function testIPInRangeEventDispatchesAndListenerSendsMessageToLogger()
    {
        $this->mockExampleIPService([
           ['shouldReceive' => 'getClientIP', 'andReturn' => '176.64.10.12'] 
        ]);
        $this->mockLoggerService([
            ['shouldReceive' => 'info', 
            'with' => "Client with IP 176.64.10.12 accessed the page.",
            'times' => 1]
        ]);
        
        $request = $this->getRequest('/example-ip-check');
        $response = $this->app->run($request)->getResponse();
        $this->assertContains(
            'Your IP is within the specified range and you can view this content.',
            $response->getBody()->__toString(),
            "Response body does not contain the expected string"
        );
    }
    
    public function testRedirectsIfIPIsNotInRange()
    {
        $this->mockExampleIPService([
            ['shouldReceive' => 'getClientIP', 'andReturn' => '1.2.3.4']
        ]);
        
        $request = $this->getRequest('/example-ip-check');
        $response = $this->app->run($request)->getResponse();
        $this->assertEquals(302, $response->getStatusCode(),
            "Response body does not have the expected status code"
        );
        $this->assertEquals('/example-controller-action/redirected',
            $response->getHeaderLine('Location'), 
            "Response body does not contain the expected header line Location"
        );
    }
    
    private function getRequest($uri, $method = 'GET')
    {
        return (new GuzzleServerRequestFactory())->createServerRequest($method, $uri);
    }
    
    private function getResponseFromRoute($uri)
    {
        $request = $this->getRequest($uri);
        $this->app->run($request);
        return $this->app->getResponse();
    }
    
    private function mockExampleIPService($expectationsArr)
    {
        $this->app->getContainer()->factory(
            \DuktigSkeleton\Service\ExampleIPService::class,
            function(\Duktig\Core\Config\ConfigInterface $config,
                \Duktig\Core\Event\Dispatcher\EventDispatcherInterface $eventDispatcher
            ) use ($expectationsArr) {
                $mockIPServicePartial = \Mockery::mock(\DuktigSkeleton\Service\ExampleIPService::class,
                    [$config, $eventDispatcher])->makePartial();
                foreach ($expectationsArr as $expectationArr) {
                    $mockIPServicePartial->shouldReceive($expectationArr['shouldReceive'])
                        ->andReturn($expectationArr['andReturn']);
                }
                return $mockIPServicePartial;
            }
        );
    }
    
    protected function mockLoggerService($expectationsArr)
    {
        $mockLogger = \Mockery::mock(\Monolog\Logger::class)->makePartial();
        foreach ($expectationsArr as $expectationArr) {
            $mockLogger->shouldReceive($expectationArr['shouldReceive'])
                ->with($expectationArr['with'])
                ->times($expectationArr['times']);
        }
        $this->app->getContainer()->alias(
            \Psr\Log\LoggerInterface::class,
            get_class($mockLogger)
        );
        $this->app->getContainer()->singleton($mockLogger);
    }
}