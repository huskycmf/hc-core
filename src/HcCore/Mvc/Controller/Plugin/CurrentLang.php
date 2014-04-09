<?php
namespace HcCore\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class CurrentLang extends AbstractPlugin
{
    /**
     * @return string
     */
    public function __invoke()
    {
        return \Locale::getDefault();
    }
}
