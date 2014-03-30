<?php
namespace HcCore\Service\Fetch\Locale;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\Locale;

class FetchAllService
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
     * @return Locale[]
     */
    public function fetch()
    {
        /* @var $repository \Doctrine\ORM\EntityRepository */
        $repository = $this->entityManager->getRepository('HcCore\Entity\Locale');
        return $repository->findAll();
    }
}
