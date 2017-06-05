<?php

namespace DuktigSkeleton\Event;

use Duktig\Core\Event\EventAbstract;

/**
 * Simple example of an event, which holds the IP addres as a value object used
 * by the listener.
 */
class EventIPInRange extends EventAbstract
{
    private $IP;
    
    public function __construct(string $IP)
    {
        parent::__construct();
        $this->IP = $IP;
    }
    
    public function getIP() : string
    {
        return $this->IP;
    }
}