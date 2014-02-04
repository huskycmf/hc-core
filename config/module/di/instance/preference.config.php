<?php
return array(
    'Zend\EventManager\EventManagerInterface' =>
        'EventManager',

    'Zend\ServiceManager\ServiceLocatorInterface' =>
        'ServiceManager',

    'Doctrine\ORM\EntityManagerInterface' =>
        'Doctrine\ORM\EntityManager',

    'HcCore\Service\Sorting\SortingServiceInterface' =>
        'HcCore\Service\Sorting\SortingService',

    'HcCore\Service\Filtration\Query\FiltrationServiceInterface' =>
        'HcCore\Service\Filtration\Query\FiltrationService',

    'HcCore\Service\Filtration\Collection\FiltrationServiceInterface' =>
        'HcCore\Service\Filtration\Collection\FiltrationService',

    'HcCore\Options\AclOptionsInterface' =>
        'HcCore\Options\ModuleOptions',

    'HcCore\Service\AuthServiceInterface' =>
        'HcCore\Service\AuthService'
);
