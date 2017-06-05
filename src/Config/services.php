<?php
/**
 * Your app's services definitions, see Core/services.php.
 */
return function($container) {
    
    /**
     * Guzzle HTTP message factories
     */
    $container->alias(
        \Interop\Http\Factory\ServerRequestFactoryInterface::class,
        \Duktig\Http\Factory\Adapter\Guzzle\GuzzleServerRequestFactory::class
    );
    $container->alias(
        \Interop\Http\Factory\ResponseFactoryInterface::class,
        \Duktig\Http\Factory\Adapter\Guzzle\GuzzleResponseFactory::class
    );
    
    /**
     * Symfony Router adapter
     */
    $container->alias(
        \Duktig\Core\Route\Router\RouterInterface::class,
        \Duktig\Route\Router\Adapter\SymfonyRouter\SymfonyRouterAdapter::class
    );
    
    /**
     * Middleman middleware dispatcher
     */
    $container->alias(
        \Interop\Http\ServerMiddleware\DelegateInterface::class,
        \Duktig\Middleware\Dispatcher\Adapter\Middleman\MiddlemanAdapter::class
    );
    
    /**
     * Symfony Event Dispatcher adapter
     */
    $container->factory(
        \Duktig\Core\Event\Dispatcher\EventDispatcherInterface::class,
        function (\Duktig\Core\Config\ConfigInterface $config,
            \Duktig\Core\DI\ContainerInterface $resolver
        ) {
            $eventsConfig = $config->getParam('events');
            $syDispatcher = new \Duktig\Event\Dispatcher\Adapter\SymfonyEventDispatcher\SymfonyEventDispatcherAdapter(
                new \Symfony\Component\EventDispatcher\EventDispatcher(),
                $resolver
            );
            foreach ($eventsConfig as $eventName => $listeners) {
                foreach ($listeners as $listener) {
                    $syDispatcher->addListener($eventName, $listener);
                }
            }
            return $syDispatcher;
        }
    );
    
    /**
     * Twig renderer
     */
    $container->alias(
        \Duktig\Core\View\RendererInterface::class,
        \Duktig\View\Adapter\Twig\TwigRenderer::class
    );
    $container->factory(
        'Twig_Environment',
        /**
         * The $paths variable for Twig_Environment is given so that Application
         * template dir comes before Core template dir when trying to render templates.
         */
        function(\Duktig\Core\Config\ConfigInterface $config) {
            $appDir = $config->getParam('appDir');
            $coreDir = $config->getParam('coreDir');
            
            $paths = [];
            $templateDirApp = $config->getParam('view')['templateDirApp'];
            $templateDirAppFullPath = $appDir . '/' . $templateDirApp;
            if ($appDir && $templateDirApp && file_exists($templateDirAppFullPath)) {
                $paths[] = $templateDirAppFullPath;
            }
            if ($templateDirCore = $config->getParam('view')['templateDirCore']) {
                $paths[] = $coreDir . '/' . $templateDirCore;
            }
            $loader = new Twig_Loader_Filesystem($paths);
            $cache = $config->getParam('view')['templateCache']
                ?? $appDir . '/' . $config->getParam('view')['templateCache'];
            $twig = new Twig_Environment($loader, array('cache' => $cache));
            return $twig;
        }
    );
    
    /**
     * Monolog
     */
    $container->alias(
        \Psr\Log\LoggerInterface::class,
        \Monolog\Logger::class
    );
    $container->factory(
        \Monolog\Logger::class,
        function (\Duktig\Core\Config\ConfigInterface $config) {
            $logFile = realpath($config->getParam('log'));
            $loger = new \Monolog\Logger('duktig');
            if ($logFile) {
                $loger->pushHandler(new \Monolog\Handler\StreamHandler(
                    $logFile
                ));
            } else {
                // push messages to web server log
                $loger->pushHandler(new \Monolog\Handler\ErrorLogHandler(
                    \Monolog\Handler\ErrorLogHandler::SAPI
                ));
            }
            return $loger;
        }
    );
    $container->singleton(
        \Monolog\Logger::class
    );
    
    return $container;
};