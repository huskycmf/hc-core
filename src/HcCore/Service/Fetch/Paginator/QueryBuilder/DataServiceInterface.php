<?php
namespace HcCore\Service\Fetch\Paginator\QueryBuilder;

use Doctrine\ORM\QueryBuilder;
use Zend\Stdlib\Parameters;
use HcCore\Service\Fetch\Paginator\DataInterface;

interface DataServiceInterface extends DataInterface
{
    /**
     * @param Parameters $params [OPTIONAL]
     * @return QueryBuilder
     */
    public function fetch(Parameters $params = null);
}
