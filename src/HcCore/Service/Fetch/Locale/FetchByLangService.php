<?php
namespace HcCore\Service\Fetch\Locale;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\Locale;

class FetchByLangService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Locale | null
     */
    public function fetch($langString)
    {
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
