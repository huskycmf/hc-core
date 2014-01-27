<?php
namespace HcCore\Service;

use App\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Configuration');
        return new ModuleOptions(isset($config['app']) ? $config['app'] : array());
    }
}
