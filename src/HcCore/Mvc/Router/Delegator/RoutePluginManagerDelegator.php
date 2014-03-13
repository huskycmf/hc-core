<?php
namespace HcCore\Mvc\Router\Delegator;

use Zend\Mvc\Router\RoutePluginManager;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Delegator for RoutePluginManager
 */
class RoutePluginManagerDelegator implements DelegatorFactoryInterface
{
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        /* @var $routePluginManager RoutePluginManager */
        $routePluginManager = $callback();
        $routePluginManager->setInvokableClass('HasLang', 'HcCore\Mvc\Router\Http\HasLang');
        return $routePluginManager;
    }
}
