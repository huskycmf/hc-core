<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',
    'controller_plugins' => array(
        'invokables' => array(
            'Params' => 'Zf2Libs\Mvc\Controller\Plugin\Params',
            'CurrentLang' => 'HcCore\Mvc\Controller\Plugin\CurrentLang'
        )
    ),

    'cache' => array(
        'adapter' => array(
            'name' => 'apc',
            'options' => array(
                'ttl' => 2592000 // cache for 30 days
            )
        ),

        'plugins' => array(
            'exception_handler' => array('throw_exceptions' => false),
            'serializer'
        )
    ),

    'doctrine' => array(
        'driver' => array(
            'app_driver' => array(
                'paths' => array(__DIR__ . '/../src/HcCore/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'HcCore\Entity' => 'app_driver'
                )
            )
        )
    ),

    'di' => include __DIR__ . '/module/di.config.php',
    'service_manager' => include __DIR__ . '/module/service_manager.config.php',

    'hc-core'=> array(
        'defaultUserRole' => '2'
    )
);
