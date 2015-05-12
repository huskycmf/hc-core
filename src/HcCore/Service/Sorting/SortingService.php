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
     * @param array $fieldToQueryColumnMap [OPTIONAL]
     * @return QueryBuilder
     */
    public function apply(Parameters $params, QueryBuilder $qb, $tableAlias = 'g',
                          array $fieldToQueryColumnMap = array())
    {
        if (is_null($params->get('sort', null)) || !strlen(trim($params->get('sort', '')))) return $qb;

        $dir = substr($params->get('sort'), 0, 1);

        if (!in_array($dir, array('-', '+'))) {
            $dir = '+';
            $column = $params->get('sort');
        } else {
            $column = substr($params->get('sort'), 1);
        }


        $column = $this->getQueryColumn(trim($column),
                                        $tableAlias,
                                        $fieldToQueryColumnMap);

        $qb->orderBy($column, $dir == '-' ? 'DESC' : 'ASC');

        return $qb;
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
