<?php
namespace HcCore\Controller\Common\Collection;

use HcCore\Entity\EntityInterface;
use HcCore\Service\FetchServiceInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Http\PhpEnvironment\Response as HttpResponse;

abstract class AbstractResourceController extends AbstractController
{
    /**
     * @var FetchServiceInterface
     */
    private $fetchService;

    /**
     * @var string
     */
    private $routerParameterName;

    /**
     * @var EntityInterface
     */
    protected $resourceEntity;

    /**
     * @var string
     */
    const EVENT_PRE_RESOURCE_FETCH = 'pre.resource.fetch';

    /**
     * @var string
     */
    const EVENT_RESOURCE_FETCHED = 'resource.fetched';

    /**
     * @param FetchServiceInterface $fetchService
     * @param string $routerParameterName [OPTIONAL]
     */
    public function __construct(FetchServiceInterface $fetchService,
                                $routerParameterName = 'id')
    {
        $this->fetchService = $fetchService;
        $this->routerParameterName = $routerParameterName;
    }

    /**
     * @return EntityInterface
     */
    protected function getResourceEntity()
    {
        return $this->resourceEntity;
    }

    /**
     * @return EntityInterface | null
     */
    protected function fetchResourceEntity()
    {
       return $this->fetchService
                   ->fetch($this->params()
                                ->fromRoute($this->routerParameterName));
    }

    /* (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractController::dispatch()
     */
    public function dispatch(Request $request, Response $response = null)
    {
        $responseCollection = $this->getEventManager()
                                   ->trigger(self::EVENT_PRE_RESOURCE_FETCH,
                                             $this, array($request, $response));

        if ($responseCollection->stopped()) {
            $response = $response ?: new HttpResponse();
            $this->getEventManager()->clearListeners(MvcEvent::EVENT_DISPATCH);
            return parent::dispatch($request, $response);
        }

        $this->resourceEntity = $this->fetchResourceEntity();

        if (is_null($this->resourceEntity)) {
            $response = $response ?: new HttpResponse();
            $this->getEventManager()->clearListeners(MvcEvent::EVENT_DISPATCH);
            $response->setStatusCode(404);
        }

        $this->getEventManager()->trigger(self::EVENT_RESOURCE_FETCHED,
                                          $this, array($this->resourceEntity));

        return parent::dispatch($request, $response);
    }
}
