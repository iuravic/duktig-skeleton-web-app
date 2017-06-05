<?php
namespace DuktigSkeleton\Event;

use Duktig\Core\Event\ListenerInterface;
use Duktig\Core\Event\EventInterface;
use Psr\Log\LoggerInterface;

/**
 * An example listener.
 */
class ListenerReportIP implements ListenerInterface
{
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * {@inheritDoc}
     * @see \Duktig\Core\Event\ListenerInterface::handle()
     */
    public function handle(EventInterface $event) : void
    {
        $message = "Client with IP ".$event->getIP()." accessed the page.";
        $this->logger->info($message);
    }
}