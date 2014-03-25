<?php
namespace HcCore\Service\Filtration\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Zend\Stdlib\Parameters;

class FiltrationService implements FiltrationServiceInterface
{
    /**
     * @param Parameters $params
     * @param ArrayCollection $collection
     * @return ArrayCollection
     */
    public function apply(Parameters $params, ArrayCollection $collection)
    {
        $criteria = new Criteria();

        foreach($params as $field=>$param) {
            if ($param == '*' || empty($param)) continue;

            $criteria->andWhere($criteria->expr()->eq($field, $param));
        }

        return $collection->matching($criteria);
    }
}
