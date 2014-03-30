<?php
namespace HcCore\Service\Filtration\Query;

use Doctrine\ORM\QueryBuilder;
use Zend\Stdlib\Parameters;

interface FiltrationServiceInterface
{
    /**
     * @param Parameters $params
     * @param QueryBuilder $qb
     * @param string $tableAlias [OPTIONAL]
     * @param array $fieldToQueryColumnMap [OPTIONAL]
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb,
                          $tableAlias = '', array $fieldToQueryColumnMap = array());
}
