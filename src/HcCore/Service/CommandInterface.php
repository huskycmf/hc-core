<?php
namespace HcCore\Service;

use Zf2Libs\Stdlib\Service\Response\Messages\Response;

interface CommandInterface
{
    /**
     * @return Response
     */
    public function execute();
}
