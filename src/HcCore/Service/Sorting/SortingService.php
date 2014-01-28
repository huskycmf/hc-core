<?php
namespace HcCore\Service\Sorting;

use Doctrine\ORM\QueryBuilder;
use Zend\Stdlib\Parameters;

class SortingService implements SortingServiceInterface
{
    /**
     * @param Parameters $params
     * @param QueryBuilder $qb
     * @param string $tableAlias
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb, $tableAlias = 'g')
    {
        if (is_null($params->get('sort', null)) || !strlen(trim($params->get('sort', '')))) return $qb;

        $dir = substr($params->get('sort'), 0, 1);
        $column = substr($params->get('sort'), 1);

        $qb->orderBy($tableAlias.'.'.$column, $dir == '-' ? 'DESC' : 'ASC');

        return $qb;
    }
}
