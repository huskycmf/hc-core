<?php
namespace HcCore\Service;

use HcCore\Entity\EntityInterface;

interface FetchServiceInterface
{
    /**
     * @param mixed $id
     * @return EntityInterface | null
     */
    public function fetch($id);
}
