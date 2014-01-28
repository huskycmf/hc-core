<?php
namespace HcCore\Service\Fetch\Paginator\ArrayCollection;

use Doctrine\Common\Collections\ArrayCollection;
use HcCore\Entity\EntityInterface;
use HcCore\Service\Fetch\Paginator\ResourceDataInterface;
use Zend\Stdlib\Parameters;
use HcCore\Service\Fetch\Paginator\Exception\InvalidResourceExceptionInterface;

interface ResourceDataServiceInterface extends ResourceDataInterface
{
    /**
     * @param mixed | EntityInterface $resource
     * @param Parameters $params [OPTIONAL]
     * @return ArrayCollection
     * @throws InvalidResourceExceptionInterface
     */
    public function fetch($resource, Parameters $params = null);
}
