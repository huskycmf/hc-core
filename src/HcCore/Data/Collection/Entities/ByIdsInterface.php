<?php
namespace HcCore\Data\Collection\Entities;

use HcCore\Entity\EntityInterface;

interface ByIdsInterface
{
    /**
     * @return EntityInterface[]
     */
    public function getEntities();
}
