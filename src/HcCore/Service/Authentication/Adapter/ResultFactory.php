<?php
namespace HcCore\Service\Authentication\Adapter;

use Zend\Authentication\Result;

class ResultFactory implements ResultFactoryInterface
{
    /**
     * @param $code
     * @param $identity
     * @return Result
     */
    public function getResult($code, $identity)
    {
        return new Result($code, $identity);
    }
}
