<?php
namespace HcCore\Service;

use HcCore\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Configuration');
        return new ModuleOptions(isset($config['hc-core']) ? $config['hc-core'] : array());
    }
}
