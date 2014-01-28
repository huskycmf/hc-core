<?php
namespace HcCore\Service\Filtration\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Stdlib\Parameters;

interface FiltrationServiceInterface
{
    /**
     * @param Parameters $params
     * @param ArrayCollection $collection
     * @return ArrayCollection
     */
    public function apply(Parameters $params, ArrayCollection $collection);
}
