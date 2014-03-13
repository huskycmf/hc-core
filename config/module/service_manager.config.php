<?php
return array(
    'factories' => array(
        'HcCore\Options\ModuleOptions' => 'HcCore\Service\ModuleOptionsFactory',
        'Zend\Authentication\AuthenticationService' => 'HcCore\Service\AuthenticationServiceFactory',
        'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        'Zend\Mvc\Router\Http\TreeRouteStack' => function ($sm) {
            return $sm->get('router');
        }
    ),

    'delegators' => array(
        'RoutePluginManager' => array('Zf2Libs\Mvc\Router\Delegator\RoutePluginManagerDelegator',
                                      'HcCore\Mvc\Router\Delegator\RoutePluginManagerDelegator')
    )
);
