<?php
return array(
    'factories' => array(
        'HcCore\Options\ModuleOptions' => 'HcCore\Service\ModuleOptionsFactory',
        'Zend\Authentication\AuthenticationService' => 'HcCore\Service\AuthenticationServiceFactory',
        'Zend\I18n\Translator\TranslatorInterface' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        'Zend\Mvc\Router\Http\TreeRouteStack' => function ($sm) { return $sm->get('router'); },
        'Zend\Cache\Service\StorageCacheFactory' => 'Zend\Cache\Service\StorageCacheFactory'
    ),

    'delegators' => array(
        'RoutePluginManager' => array('Zf2Libs\Mvc\Router\Delegator\RoutePluginManagerDelegator',
                                      'HcCore\Mvc\Router\Delegator\RoutePluginManagerDelegator')
    )
);
