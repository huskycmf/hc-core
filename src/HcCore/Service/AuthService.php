<?php
namespace HcCore\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\RequestInterface;
use ZfcUser\Authentication\Adapter\AdapterChain;

class AuthService implements AuthServiceInterface
{
    /**
     * @var AdapterChain
     */
    protected $adapterChain;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    public function __construct(AdapterChain $adapterChain,
                                AuthenticationService $authService)
    {
        $this->adapterChain = $adapterChain;
        $this->authService = $authService;
    }

    /**
     * @param RequestInterface $request
     * @return bool | Response
     */
    public function authorize(RequestInterface $request)
    {
        /* @var $adapter \ZfcUser\Authentication\Adapter\AdapterChain */
        $result = $this->adapterChain->prepareForAuthentication($request);

        // Return early if an adapter returned a response
        if ($result instanceof Response) {
            return $result;
        }

        $auth = $this->authService->authenticate($this->adapterChain);

        if (!$auth->isValid()) {
            $this->adapterChain->resetAdapters();
            return false;
        }

        return true;
    }
}
