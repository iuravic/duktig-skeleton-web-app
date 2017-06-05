<?php
/**
 * Your app's events configuration, see Core/events.php.
 */
return [
    \DuktigSkeleton\Event\EventIPInRange::class => [
        \DuktigSkeleton\Event\ListenerReportIP::class,
    ],
];