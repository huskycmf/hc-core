<?php
namespace HcCore\Service;

use HcCore\Entity\EntityInterface;
use Zf2Libs\Stdlib\Service\Response\Messages\Response;

interface ResourceCommandInterface
{
    /**
     * @param EntityInterface $resource
     * @return Response
     */
    public function execute(EntityInterface $resource);
}
