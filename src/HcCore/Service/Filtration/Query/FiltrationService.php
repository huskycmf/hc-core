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
        foreach($params as $cond=>$param) {
            if ($param == '*' || !isset($param)) continue;
            list($fieldName, $expr) = $this->_getExpr($tableAlias, $cond, $qb->expr());
            $qb->andWhere($expr)->setParameter($fieldName, $param);
        }

        return $qb;
    }

    /**
     * @param string $tableAlias
     * @param string $cond
     * @param Expr $expr
     * @return array
     */
    protected function _getExpr($tableAlias, $cond, Expr $expr)
    {
        if (!preg_match('/(>=|<=|<|>|=|\!=)/', $cond, $matches)) {
            $operator = '=';
        } else {
            $operator = trim($matches[1]);
            $cond = trim(str_replace($operator, '', $cond));
        }

        switch ($operator) {
            case Expr\Comparison::NEQ :
                $method = 'neq'; break;
            case Expr\Comparison::GT :
                $method = 'gt'; break;
            case Expr\Comparison::LT :
                $method = 'lt'; break;
            case Expr\Comparison::LTE :
                $method = 'lte'; break;
            case Expr\Comparison::GTE :
                $method = 'gte'; break;
            case Expr\Comparison::EQ :
            default:
                $method = 'eq';
        }

        $paramName = uniqid($cond.'_');
        return array($paramName, $expr->{$method}($tableAlias.'.'.$cond, ':'.$paramName));
    }
}
