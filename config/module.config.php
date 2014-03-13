<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',
    'controller_plugins' => array(
        'invokables' => array(
            'Params' => 'Zf2Libs\Mvc\Controller\Plugin\Params'
        )
    ),

    'di' => include __DIR__ . '/module/di.config.php',
    'service_manager' => include __DIR__ . '/module/service_manager.config.php',

    'hc-core'=> array(
        'defaultUserRole' => '2'
    )
);
