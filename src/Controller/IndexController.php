<?php
namespace DuktigSkeleton\Controller;

use Duktig\Core\Controller\BaseController;
use Psr\Http\Message\ResponseInterface;
use DuktigSkeleton\Service\ExampleIPService;
use Interop\Http\Factory\ResponseFactoryInterface;
use Duktig\Core\View\RendererInterface;
use Duktig\Core\Config\ConfigInterface;

class IndexController extends BaseController
{
    private $IPService;
    
    /**
     * Simple example showing how to inject custom services, with respect to
     * the parent class DI.
     * 
     * @param ResponseFactoryInterface $responseFactory
     * @param RendererInterface $renderer
     * @param ConfigInterface $config
     * @param ExampleIPService $IPService
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        RendererInterface $renderer,
        ConfigInterface $config,
        ExampleIPService $IPService
    )
    {
        parent::__construct($responseFactory, $renderer, $config);
        $this->IPService = $IPService;
    }
    
    /**
     * Simple example returning a rendered template
     * 
     * @param string $slug
     * @return ResponseInterface
     */
    public function indexAction(string $slug) : ResponseInterface
    {
        $html = $this->render([
            'title' => 'Sample page indexAction',
            'uriParamsArr' => [$slug],
            'queryParamsArr' => $this->getQueryParams(),
            'clientIP' => $this->request->getAttribute('clientIP'),
        ]);
        $this->writeResponseBody($html);
        
        return $this->response;
    }
    
    /**
     * Checks if the client IP is within the defined range. If not, it redirects
     * to the indexAction.
     * 
     * @return ResponseInterface
     */
    public function checkIPAction() : ResponseInterface
    {
        if (!$this->IPService->isIPInRange()) {
            $this->response = $this->response->withStatus(302)
                ->withHeader('Location', '/example-controller-action/redirected');
            return $this->response;
        }
        
        $this->writeResponseBody('<p>Your IP is within the specified range and'
            .' you can view this content.</p>');
        
        return $this->response;
    }
}