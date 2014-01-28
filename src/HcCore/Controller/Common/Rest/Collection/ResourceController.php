<?php
namespace HcCore\Controller\Common\Rest\Collection;

use HcCore\Service\FetchServiceInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zf2Libs\Stdlib\Extractor\ExtractorInterface;

class ResourceController extends AbstractResourceController
{
    /**
     * @var ExtractorInterface
     */
    protected $extractor;

    /**
     * @var JsonModel
     */
    protected $responseModel;

    /**
     * @param FetchServiceInterface $fetchService
     * @param ExtractorInterface $extractor
     * @param JsonModel $responseModel
     */
    public function __construct(FetchServiceInterface $fetchService,
                                ExtractorInterface $extractor,
                                JsonModel $responseModel)
    {
        parent::__construct($fetchService);

        $this->extractor = $extractor;
        $this->responseModel = $responseModel;
    }

    /**
     * @param MvcEvent $e
     * @return mixed|void
     */
    public function onDispatch(MvcEvent $e)
    {
        $this->responseModel->setVariables($this->extractor->extract($this->resourceEntity));
        $e->setResult($this->responseModel);
    }
}
