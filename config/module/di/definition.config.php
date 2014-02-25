<?php
return array(
    'class' => array(
        'HcCore\Controller\Common\Rest\Collection\DataController' => array(
            '__construct' => array(
                'inputData' => array(
                    'type' => 'HcCore\Data\DataMessagesInterface',
                    'required' => false,
                    'default' => null
                ),
                'serviceCommand' => array(
                    'type' => 'HcCore\Service\CommandInterface',
                    'required' => true
                ),
                'jsonResponseModelFactory' => array(
                    'type' => 'Zf2Libs\View\Model\Json\Specific\StatusMessageDataModelFactoryInterface',
                    'required' => true
                )
            )
        ),
        'HcCore\Service\FetchService' => array(
            '__construct' => array(
                'entityManager' => array(
                    'type' => 'Doctrine\ORM\EntityManagerInterface',
                    'required' => true
                ),
                'entityName' => array(
                    'type' => false,
                    'required' => true
                )
            )
        ),
        'HcCore\Service\Collection\IdsService' => array(
            '__construct' => array(
                'entityManager' => array(
                    'type' => 'Doctrine\ORM\EntityManagerInterface',
                    'required' => true
                ),
                'di' => array(
                    'type' => 'Zend\Di\Di',
                    'required' => true
                ),
                'entityName' => array(
                    'type' => false,
                    'required' => true
                )
            )
        )
    )
);
