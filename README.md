# duktig-skeleton-web-app

The skeleton web application based on [`iuravic/duktig-core`](https://github.com/iuravic/duktig-core) package.

-----------------------------------------------------------------------------------------

## About

The `duktig-skeleton-web-app` is a starting point for developing your own applications with the Duktig framework. It is founded on the [`duktig-core`](https://github.com/iuravic/duktig-core) package, and it provides it with all its necessary dependencies. The skeleton application also contains functional examples of most of the Duktig framework's major features.

### `duktig-core` package

It is advisable to also inspect the [`duktig-core` documentation](https://github.com/iuravic/duktig-core) which describes the purpose and features of the Duktig framework, as well as explains its base elements and functionalities.

-----------------------------------------------------------------------------------------

## Package design

Most of the Duktig's core services are fully decoupled from the [`duktig-core`](https://github.com/iuravic/duktig-core) package. The `duktig-core` simply describes them by its interfaces, and each of them is found as a separate package in the form of an adapter towards a readily available open-source project. This kind of approach provides high flexibility, reusability, and generally stands as a good package design.

### Dependencies

The `duktig-skeleton-web-app` composes the full Duktig web application framework by using popular and tested open-source packages. Adapter packages are used simply to adapt the external packages' APIs to the core's interfaces, therefore making them usable by the [`duktig-core`](https://github.com/iuravic/duktig-core).

The following projects and packages are used here to provide the full functionalities for Duktig framework:

Project | Adapter package
--- | ---
[Guzzle HTTP messages](https://github.com/guzzle/psr7) | [`duktig-http-factory-guzzle-adapter`](https://github.com/iuravic/duktig-http-factory-guzzle-adapter)
[Symfony Router](https://github.com/symfony/routing) | [`duktig-symfony-router-adapter`](https://github.com/iuravic/duktig-symfony-router-adapter)
[Symfony Event Dispatcher](https://github.com/symfony/event-dispatcher) | [`duktig-symfony-event-dispatcher-adapter`](https://github.com/iuravic/duktig-symfony-event-dispatcher-adapter)
[Monolog](https://github.com/Seldaek/monolog) | /
[Middleman middleware dispatcher](https://github.com/mindplay-dk/middleman) | [`duktig-middleman-adapter`](https://github.com/iuravic/duktig-middleman-adapter)
[Twig renderer](https://github.com/twigphp/Twig) | [`duktig-twig-adapter`](https://github.com/iuravic/duktig-twig-adapter)

### Core services

The [`services.php`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/services.php) file shows how these packages are implemented and configured to provide for the core functionality.

-----------------------------------------------------------------------------------------

## Example project functionalities

Within this package several functionalities are implemented as simple show-case examples. These can be looked up for "how-tos", they can be modified, or simply removed from your project. Basically they should serve to show a quick way around building apps with the Duktig framework.

Following is a quick list of available functionalities.

### Core services

The [`'Config/services.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/services.php) defines and registers all of the [core services](TODO) by using external packages.

### Routes

See route configuration [`Config/routes.php`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/routes.php).

Path | Route | Features
--- | --- | ---
`/` | 'landing-page' | Landing page
`/example-controller-action/{myParam}` | 'example-route-w-controller' | URI path params; Route specific middleware
`/example-ip-check` | 'example-ip-check' | 
`/example-callable-handler` | 'example-route-with-callable-handler' | closure-type route handler; 

### Controllers

See controller directory [`Controller/`](https://github.com/iuravic/duktig-skeleton-web-app/tree/master/src/Controller).

The `DuktigSkeleton\Controller\IndexController` features:
- extension of the `BaseController` class
- constructor parameter resolution
- use of external services
- response definition
- template rendering
- redirection
- URI path parameters
- query parameters

### Middlewares

The following middlewares are implemented with their corresponding features:
- Application-wide middleware [`ExampleAppMiddleware`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Middleware/ExampleAppMiddleware.php):
  - registers in the configuration file [`'Config/middlewares.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/middlewares.php)
  - modifies the response body
- Route specific middleware [`ExampleGetIPRouteMiddleware`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Middleware/ExampleGetIPRouteMiddleware.php):
  - assigned to the route [`'example-route-w-controller'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/routes.php)
  - uses an external service by dependency injection
  - modifies the application request by adding an attribute to it

### Events

The event [`EventIPInRange`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Event/EventIPInRange.php) is a simple event object which shows how to:
- extend the `EventAbstract` class
- use external services
- represent contextual data for its listeners

The `EventIPInRange` has one listener attached and registered via the [`Config/events.php`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/events.php) config file, the [`ListenerReportIP`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Event/ListenerReportIP.php), which demponstrates how to:
- implement the `ListenerInterface`
- use external services
- handle the event object and perform a task

### Services

The [`ExampleIPService`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Service/ExampleIPService.php) is a simple service which implements a few basic features:
- the `ExampleIPService` itself is being resolved by the use of the container's automatic provisioning feature (notice that it was not specifically registered in the [`Config/services.php`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/services.php), since the Auryn uses the feature)
- dependency injection
- access to the configuration service and config parameters

### Configuration

The following configuration settings are implemented in the skeleton project:
- the base configuration file [`'Config/config.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/config.php) with its settings
- setting custom configuration parameters in the [`'Config/params.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/params.php)
- registering application middleware in the [`'Config/middlewares.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/middlewares.php)
- registering events with listeners in the [`'Config/events.php'`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/events.php)





-----------------------------------------------------------------------------------------

## Application flow

Let's take a look at a full request-to-response life-cycle, and some of its key elements, in the order in which they come up in the chain of command.


### index.php

A typical index.php file would look like this:

```php
  <?php
    require __DIR__.'/../vendor/autoload.php';

    $app = (new \Duktig\Core\AppFactory)->make(
        __DIR__.'/../src/Config/config.php',
        \Duktig\Core\App::class
    );

    $app->run();
```

We see that the app is created by the [`Duktig\Core\AppFactory`](https://github.com/iuravic/duktig-core/blob/master/src/Core/AppFactory.php) by providing the custom configuration file and the application class.


### `AppFactory`

The [`Duktig\Core\AppFactory`](https://github.com/iuravic/duktig-core/blob/master/src/Core/AppFactory.php) creates an instance of the application by:

- taking the user configuration and merging it with core configuration,
- instantiating and configuring the DI container through the use of the [`Duktig\Core\DI\ContainerFactory`](https://github.com/iuravic/duktig-core/blob/master/src/Core/DI/ContainerFactory.php),
- resolving the app with its dependencies.


### Request processing

The [`Duktig\Core\App`](https://github.com/iuravic/duktig-core/blob/master/src/Core/App.php)'s method `run()` is the entry point for the request. The framework "runs" the request through the full application stack. It employs HTTP middleware at its core and composes a middleware stack which consists of:

- application middleware,
- route middleware,
- controller responder middleware.

Two kinds of middleware exist in Duktig: the application middleware -- which is used on every request, and the route specific middleware -- which can be assigned to a specific route.

At the end of the middleware stack lies the [ControllerResponder](TODO) middleware. It is incharged of resolving the controller/route handler, and returning the response object from it to the stack.

After finishing processing the response, the framework sends it to the browser and terminates the application business.

-----------------------------------------------------------------------------------------

## Configuration

Before taking a final step and delving into the configuration, please take a moment to also look the [`duktig-core`](https://github.com/iuravic/duktig-core)'s own documentation and the framework project description.


### Configuration files

Duktig's configuration is contained within the simple [`.php` config files](https://github.com/iuravic/duktig-core/tree/master/src/Config) inside the `Config` directory. Your application's `Config` folder should mirror the contents of the `duktig-core`'s config. The core's and your application's configurations get fully merged at runtime, and all thhe config values defined in your application overwrite those from the core's. The only exception to this is the `services.php` file whose content is not overwritten, but merged with your application's `services.php`. In order to skip the core's services configuration, the config parameter `'skipCoreServices'` can be used.


### The configuration service

The configuration service is used to access the configuration parameters and values, that is the contents of the `config.php` file. It implements a simple API given by the `Duktig\Core\Config\ConfigInterface`.

It can be accessed via dependency injection, where it is type-hinted as the `ConfigInterface`, which will then have the `Duktig\Core\Config\Config` service resolved in its place.

The configuration service is a shared service, meaning that its instantiation will not return a blank instance, but an already configured value object.


### Registering services

Services are registered in the `Config/services.php` file in your app folder. This file must return a closure which gets the container as it's argument, and returns it after configuring it.

```php
<?php
return function($container) {
    // ...
    return $container;
};
```



### Middleware

Duktig uses the "single-pass" [PSR-15](http://www.php-fig.org/psr/) compatible middleware and its dispatching system. Two different middleware types exist within the framework.

#### Application middleware

The application middleware is one which is run with every request. It is the app-wide middleware, and is defined in the `Config/middleware.php` configuration file in your app's folder. This example shows two application middlewares being assigned:

```php
<?php
return [
    \MyProject\Middleware\ExampleAppMiddleware1::class,
    \MyProject\Middleware\ExampleAppMiddleware2::class,
];
```

#### Route middleware

The route middleware is assigned to a specific route and is only run when that route is resolved. The route middleware is defined in your app's `Config/routes.php` file by using the `'middlewares'` route config parameter. This example shows one route specific middleware being assigned to the `'example-route'` route:

```php
<?php
return [
    'example-route' => [
        // ...
        'middlewares' => [
            \MyProject\Middleware\ExampleRouteMiddleware::class,
        ],
    ],
];
```


### Events

Events and listeners can be registered either programatically or by using the configuration.

#### Registration via the config file

To register events and their listeners, the `Config/events.php` file in your app's directory is used. The following example shows registering two events with a listener each:

```php
<?php
/* Config/events.php */
return [
    \MyProject\Event\EventIPInRange::class => [
        \MyProject\Event\ListenerReportIP::class,
    ],
    'custom-event-name' => [
        function($event) {
            // ...
            $event->getName();
        },
    ],
];
```

The first event exists as a standalone class and uses its fully qualified class name as the event's name. Its listener `ListenerReportIP` is defined as a standalone class as well. All such events with a class of their own must extend the `Duktig\Core\Event\EventAbstract` class. And all such listeners must implement the `Duktig\Core\Event\ListenerInterface`. Both the event and the listener are resolved by the container, and have their constructor dependencies injected.

The second event is defined by a custom name, and has one closure-type listener assigned to it. The closure-type listener can be assigned to any event, be it a standalone class or an event with a custom name. This listener can take only one argument, the event, and does not get resolved by the container.

In case the event is determined only by its unique name, and holds no specific contextual information for its listeners, it can be dispatched and instantiatiated as the special `Duktig\Core\Event\EventSimple` class. The `EventSimple` class creates an event on-the-fly requiring only its unique name.

#### Programatic configuration

To attach listeners programatically, we use the event dispatcher's API defined by the `Duktig\Core\Event\Dispatcher\EventDispatcherInterface`. The following example registers the same events and listeners as the previous example where the configuration file is used:

```php
<?php
    $eventDispatcher->addListener(
        \MyProject\Event\EventIPInRange::class,
        \MyProject\Event\ListenerReportIP::class
    );
    $eventDispatcher->addListener(
        'custom-event-name',
        function($event) {
            // ...
        }
    );
```

Custom listeners can be added to the [core events](https://github.com/iuravic/duktig-core/blob/master/src/Config/events.php) in the same way, therefore tapping access to the framework's internal check-points.


### Routes

Routes are defined in the `Config/route.php` file. Since Duktig's [route model](https://github.com/iuravic/duktig-core/blob/master/src/Core/Route/Route.php) is heavily influenced by the Symfony's route model, it's elements match it quite closely.

Here is an example of a route which takes an URI path parameter called `myParam`. The parameter gets passed as an argument to the `IndexController::exampleAction`. This route also has the `ExampleRouteMiddleware` assigned to it.

```php
<?php
return [
    'example-route-w-controller' => [
        'path' => '/example/{myParam}',
        'params_requirements' => ['myParam' => '.*'],
        'handler' => \MyProject\Controller\IndexController::class,
        'handler_method' => 'exampleAction',
        'methods' => ['GET'],
        'middlewares' => [\MyProject\Middleware\ExampleRouteMiddleware::class],
    ],
];
```

Another example is a route with an optional trailing slash at the end, which uses a closure-type handler (the handler gets resolved by the container and it's arguments are injected):

```php
<?php
return [
    'example-route-with-callable-handler' => [
        'path' => '/example-callable-handler{trailingSlash}',
        'params_requirements' => ['trailingSlash' => '/?'],
        'handler' => function (\Interop\Http\Factory\ResponseFactoryInterface $responseFactory) {
            $response = $responseFactory->createResponse();
            $response->getBody()->write('Response set by a callable route handler');
            return $response;
        },
        'handler_method' => null,
        'methods' => ['GET'],
    ]
];
```

The full list of route configuration parameters can be found in the [`Config/routes.php`](https://github.com/iuravic/duktig-skeleton-web-app/blob/master/src/Config/routes.php) file.