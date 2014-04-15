<?php
namespace HcCore;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        /* @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();

        /* @var $di \Zend\Di\Di */
        $di = $sm->get('di');

        /* @var $moduleOptions \HcCore\Options\ModuleOptions */
        $moduleOptions = $sm->get('HcCore\Options\ModuleOptions');

        $di->instanceManager()
            ->addSharedInstance($moduleOptions,
                                'HcCore\Options\ModuleOptions');

        $eventManager = $e->getApplication()->getEventManager();

        /* @var $cacheStorage \Zend\Cache\Storage\StorageInterface */
        $cacheStorage = $sm->get('HcCore-CacheStorage');

        $di->instanceManager()->addTypePreference('Zend\Cache\Storage\StorageInterface', get_class($cacheStorage));
        $di->instanceManager()->addSharedInstance($cacheStorage, get_class($cacheStorage));

        if ($moduleOptions->getIncludeValidatorLocalizedMessages()) {
            $translatorCacheId = 'HcCore_Validator_Translator';
            if (!$cacheStorage->hasItem($translatorCacheId)) {
                /* @var $fetchAllService \HcCore\Service\Fetch\Locale\FetchAllService */
                $fetchAllService = $di->newInstance('HcCore\Service\Fetch\Locale\FetchAllService',
                                                    array('entityManager'=>$sm->get('Doctrine\ORM\EntityManager')));

                /* @var $validatorTranslator \Zend\Mvc\I18n\Translator */
                $validatorTranslator = $di->newInstance('Zend\Mvc\I18n\Translator',
                                                        array('translator'=>
                                                                $sm->get('Zend\I18n\Translator\TranslatorInterface')),
                                                        false);

                $template = 'vendor/zendframework/zendframework/resources/languages/%s/Zend_Validate.php';
                foreach ($fetchAllService->fetch() as $localeEntity) {
                    if (file_exists($resourcePath = sprintf($template, $localeEntity->getLang()))) {
                        $validatorTranslator->addTranslationFile('phpArray',
                                                                 $resourcePath,
                                                                 'default',
                                                                 $localeEntity->getLocale());
                    }
                }

                $cacheStorage->setItem($translatorCacheId, $validatorTranslator);
            }

            \Zend\Validator\AbstractValidator::setDefaultTranslator($cacheStorage->getItem($translatorCacheId));
        }

        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'initLocale'), -10000);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'initLocale'), -10000);
    }

    /**
     * @param MvcEvent $e
     */
    public function initLocale(MvcEvent $e)
    {
        /* @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();

        /* @var $di \Zend\Di\Di */
        $di = $sm->get('di');

        /* @var $translator \Zend\I18n\Translator\Translator */
        $translator = $sm->get('Zend\I18n\Translator\TranslatorInterface');

        /* @var $localeDetector \HcCore\Service\Fetch\Locale\FetchByLangService */
        $localeDetector = $di->get('HcCore\Service\Fetch\Locale\FetchByLangService');

        if (!is_null($e->getRouteMatch())) {
            $lang = $e->getRouteMatch()->getParam('lang');
        } else {
            /* @var $request \Zend\Http\PhpEnvironment\Request */
            $request = $e->getRequest();
            $lang = substr($request->getRequestUri(), 1, 2);
        }

        /* @var $localeEntity \HcCore\Entity\Locale */
        $localeEntity = $localeDetector->fetch($lang);

        if (!is_null($localeEntity)) {
            $translator->setLocale($localeEntity->getLocale());
        } else {
            $localeEntity = $di->get('HcCore\Service\Fetch\Locale\FetchDefaultService')->fetch();
            $translator->setLocale($localeEntity->getLocale());
            if (!empty($lang)) {
                $e->getResponse()->setStatusCode(404);
                if (!is_null($e->getRouteMatch())) {
                    $e->getRouteMatch()->setParam('lang', '');
                }
            }
        }

        $di->instanceManager()->addSharedInstance($localeEntity, 'HcCore\Entity\Locale');
        \Locale::setDefault($localeEntity->getLocale());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }
}
