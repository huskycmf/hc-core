<?php
namespace HcCore\Service;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Data\LocaleInterface;
use HcCore\Entity\LocaleBindInterface;
use HcCore\Stdlib\Service\Response\Locale\BindResponse;

class LocaleBinderService implements LocaleBinderServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var BindResponse
     */
    protected $bindResponse;

    /**
     * @param EntityManagerInterface $entityManager
     * @param BindResponse $bindResponse
     */
    public function __construct(EntityManagerInterface $entityManager,
                                BindResponse $bindResponse)
    {
        $this->entityManager = $entityManager;
        $this->bindResponse = $bindResponse;
    }

    /**
     * @param LocaleInterface $localeData
     * @param LocaleBindInterface $localeBind
     * @return BindResponse
     */
    public function bind(LocaleInterface $localeData, LocaleBindInterface $localeBind)
    {
        $repository = $this->entityManager->getRepository('HcCore\Entity\Locale');
        $localeEntity = $repository->findOneBy(array('locale'=>$localeData->getLocale()));

        if (is_null($localeEntity)) {
            return $this->bindResponse->localeDoesNotSupport();
        }

        $localeBind->setLocale($localeData->getLocale());
        return $this->bindResponse->success();
    }
}
