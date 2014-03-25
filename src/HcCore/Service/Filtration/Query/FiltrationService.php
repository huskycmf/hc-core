<?php
namespace HcCore\Service\Filtration\Query;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use Zend\Stdlib\Parameters;

class FiltrationService implements FiltrationServiceInterface
{
    /**
     * @var array
     */
    protected $fieldToQueryColumnMap = array();

    /**
     * @param array $fieldToQueryColumnMap
     */
    public function __construct($fieldToQueryColumnMap = array())
    {
        $this->fieldToQueryColumnMap = $fieldToQueryColumnMap;
    }

    /**
     * @param Parameters $params
     * @param QueryBuilder $qb
     * @param string $tableAlias
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb, $tableAlias = '')
    {
        foreach($params as $fieldName => $param) {
            if ($param == '*' || !isset($param)) continue;

            list($fieldName, $expr) = $this->_getExpr($tableAlias, $fieldName, $qb->expr());

            $qb->andWhere($expr)->setParameter($fieldName, $param);
        }

        return $qb;
    }

    /**
     * @param string $tableAlias
     * @param string $fieldName
     * @param Expr $expr
     * @return array
     */
    protected function _getExpr($tableAlias, $fieldName, Expr $expr)
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

        $expr = $expr->{$method}($this->getQueryColumn($fieldName, $tableAlias), ':'.$fieldName);

        return array($fieldName, $expr);
    }

    /**
     * @param string $fieldName
     * @param string $tableAlias
     * @return string
     */
    protected function getQueryColumn($fieldName, $tableAlias)
    {
        if (array_key_exists($fieldName, $this->fieldToQueryColumnMap)) {
            return $this->fieldToQueryColumnMap[$fieldName];
        } else if (!empty($tableAlias)) {
            return $tableAlias.'.'.$fieldName;
        } else {
            return $fieldName;
        }
    }
}
