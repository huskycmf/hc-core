<?php
namespace HcCore\Service;

use HcCore\Data\LocaleInterface;
use HcCore\Entity\LocaleBindInterface;
use HcCore\Stdlib\Service\Response\Locale\BindResponse;

interface LocaleBinderServiceInterface
{
    /**
     * @param LocaleInterface $localeData
     * @param LocaleBindInterface $localeBind
     * @return BindResponse
     */
    public function bind(LocaleInterface $localeData, LocaleBindInterface $localeBind);
}
