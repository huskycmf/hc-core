<?php
namespace HcCore\Controller\Common\Rest\Collection;

use Doctrine\ORM\QueryBuilder;
use HcCore\Controller\Common\Collection\AbstractResourceController;
use HcCore\Service\Fetch\Paginator;
use HcCore\Service\FetchServiceInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\MvcEvent;
use Zf2Libs\Paginator\ViewModel\JsonModelInterface;
use HcCore\Service\DojoRestStorePaginatorFactory;

class ResourceListController extends AbstractResourceController
{
    /**
     * @var Paginator\ArrayCollection\ResourceDataServiceInterface |
     *      Paginator\QueryBuilder\ResourceDataServiceInterface
     */
    protected $paginatorDataFetchService;

    /**
     * @var DojoRestStorePaginatorFactory
     */
    protected $paginatorFactory;

    /**
     * @var JsonModelInterface
     */
    protected $viewModel;

    /**
     * @param FetchServiceInterface $fetchService
     * @param Paginator\ResourceDataInterface $paginatorDataFetchService
     * @param DojoRestStorePaginatorFactory $paginator
     * @param JsonModelInterface $viewModel
     */
    public function __construct(FetchServiceInterface $fetchService,
                                Paginator\ResourceDataInterface $paginatorDataFetchService,
                                DojoRestStorePaginatorFactory $paginator,
                                JsonModelInterface $viewModel)
    {
        parent::__construct($fetchService);

        $this->paginatorDataFetchService = $paginatorDataFetchService;
        $this->paginatorFactory = $paginator;
        $this->viewModel = $viewModel;
    }

    /**
     * @param MvcEvent $e
     * @return mixed|void
     */
    public function onDispatch(MvcEvent $e)
    {
        $data = $this->paginatorDataFetchService->fetch($this->resourceEntity,
                                                        $this->getRequest()->getQuery());

        $this->viewModel->setPaginator($this->paginatorFactory
                                            ->getPaginator($data,
                                                           $this->getRequest(),
                                                           $this->getResponse()));

        $e->setResult($this->viewModel);
    }
}
