<?php
namespace HcCore\Service;

use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\RequestInterface;

interface AuthServiceInterface
{
    /**
     * @param RequestInterface $request
     * @return bool | Response
     */
    public function authorize(RequestInterface $request);
}
