<?php
namespace HcCore\Service\Authentication\Adapter;

use Zend\Di\Di;
use Zend\Authentication\Result;

interface ResultFactoryInterface
{
    /**
     * @param $code
     * @param $identity
     * @return Result
     */
    public function getResult($code, $identity);
}
