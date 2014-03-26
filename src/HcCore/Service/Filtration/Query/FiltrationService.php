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
     * @param array $fieldToQueryColumnMap [OPTIONAL]
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb,
                          $tableAlias = '', array $fieldToQueryColumnMap = array())
    {
        $this->fieldToQueryColumnMap = $fieldToQueryColumnMap;

        foreach($params as $fieldName => $param) {
            if ($param == '*' || !isset($param)) continue;

            list($fieldName, $method) = $this->_processFieldName($fieldName);

            $expr = $qb->expr()->{$method}($this->getQueryColumn($fieldName,
                                                                 $tableAlias,
                                                                 $fieldToQueryColumnMap), ':'.$fieldName);

            $qb->andWhere($expr)->setParameter($fieldName, $param);
        }

        return $qb;
    }

    /**
     * @param string $fieldName
     * @return array
     */
    protected function _processFieldName($fieldName)
    {
        if (!preg_match('/(>=|<=|<|>|=|\!=)/', $fieldName, $matches)) {
            $operator = '=';
        } else {
            $operator = trim($matches[1]);
            $fieldName = trim(str_replace($operator, '', $fieldName));
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

        return array($fieldName, $method);
    }

    /**
     * @param string $fieldName
     * @param string $tableAlias
     * @param array $fieldToQueryColumnMap [OPTIONAL]
     * @return string
     */
    protected function getQueryColumn($fieldName, $tableAlias, array $fieldToQueryColumnMap = array())
    {
        if (!empty($fieldToQueryColumnMap) && array_key_exists($fieldName, $fieldToQueryColumnMap)) {
            return $fieldToQueryColumnMap[$fieldName];
        } else if (!empty($tableAlias)) {
            return $tableAlias.'.'.$fieldName;
        } else {
            return $fieldName;
        }
    }
}
