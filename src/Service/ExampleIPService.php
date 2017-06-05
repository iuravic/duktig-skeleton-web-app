<?php
namespace DuktigSkeleton\Service;

use DuktigSkeleton\Event\EventIPInRange;
use Duktig\Core\Config\ConfigInterface;
use Duktig\Core\Event\Dispatcher\EventDispatcherInterface;

/**
 * An example service. It determines the client's IP address and checks if it
 * is within the range specified in the app configuration.
 */
class ExampleIPService
{
    private $config;
    private $eventDispatcher;
    
    public function __construct(
        ConfigInterface $config, 
        EventDispatcherInterface $eventDispatcher)
    {
        $this->config = $config;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * Gets the client's IP address.
     * 
     * @return string|NULL
     */
    public function getClientIP() : ?string
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }
    
    /**
     * Checks if the client's IP address is within the range specified in the
     * configuration.
     * 
     * @return bool
     */
    public function isIPInRange() : bool
    {
        $IPfrom = $this->config->getParam('params')['IPRange']['from'];
        $IPto = $this->config->getParam('params')['IPRange']['to'];
        $IP = $this->getClientIP();
        
        if (ip2long($IP) >= ip2long($IPfrom) && ip2long($IP) <= ip2long($IPto)) {
            $this->eventDispatcher->dispatch(new EventIPInRange($IP));
            return true;
        }
        
        return false;
    }
}