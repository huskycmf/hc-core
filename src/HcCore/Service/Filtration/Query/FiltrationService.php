<?php
namespace HcCore\Service\Filtration\Query;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Zend\Stdlib\Parameters;

class FiltrationService implements FiltrationServiceInterface
{
    /**
     * @param Parameters $params
     * @param QueryBuilder $qb
     * @param string $tableAlias
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb, $tableAlias = '')
    {
        foreach($params as $field=>$param) {
            if ($param == '*' || empty($param)) continue;
            $qb->andWhere($qb->expr()->eq($tableAlias.'.'.$field, ':'.$field));
            $qb->setParameter($field, $param);
        }

        return $qb;
    }
}
