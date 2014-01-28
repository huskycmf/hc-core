<?php
namespace HcCore\Service\Collection;

use HcCore\Entity\EntityInterface;
use HcCore\Service\Collection\IdsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Zend\Di\Di;

class IdsService implements IdsServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Zend\Di\Di
     */
    protected $di;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Di $di
     * @param string $entityName
     */
    public function __construct(EntityManagerInterface $entityManager,
                                Di $di,
                                $entityName)
    {
        $this->entityManager = $entityManager;
        $this->di = $di;
        $this->entityName = $entityName;
    }

    /**
     * @param array $ids
     * @return EntityInterface[]
     */
    public function fetch(array $ids)
    {
        $digitsFilter = $this->di->get('Zend\Filter\Digits');

        /* @var $qb QueryBuilder */
        $qb = $this->entityManager
                   ->getRepository($this->entityName)
                   ->createQueryBuilder('e');

        $qb->where($qb->expr()->in('e', array_map(function ($id) use ($digitsFilter){
            return $digitsFilter->filter($id);
        }, $ids)));
        return $qb->getQuery()->getResult();
    }
}
