<?php
return array(
    'router' => include __DIR__ . '/module/router.config.php',

    'di' => include __DIR__ . '/module/di.config.php',

    'hc-core'=> array(
        'defaultUserRole' => '2',
        'defaultLanguage' => 'ru'
    )
);
