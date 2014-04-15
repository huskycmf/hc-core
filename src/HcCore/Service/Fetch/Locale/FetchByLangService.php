<?php
namespace HcCore\Service\Fetch\Locale;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\Locale;
use HcCore\Validator\Locale as LocaleValidator;

class FetchByLangService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var LocaleValidator
     */
    protected $localeValidator;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager,
                                LocaleValidator $localeValidator)
    {
        $this->entityManager = $entityManager;
        $this->localeValidator = $localeValidator;
    }

    /**
     * @return Locale | null
     */
    public function fetch($langString)
    {
        if (!$this->localeValidator->isValid($langString)) {
            return null;
        }

        /* @var $repository \Doctrine\ORM\EntityRepository */
        $repository = $this->entityManager->getRepository('HcCore\Entity\Locale');

        $qb = $repository->createQueryBuilder('loc');
        $qb->where('loc.lang = :lang')
           ->orderBy('loc.priority', 'ASC')
           ->setMaxResults(1)
           ->setParameter('lang', $langString);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
