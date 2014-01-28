<?php
namespace HcCore\Service;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\EntityInterface;

class FetchService implements FetchServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string $entityName
     */
    public function __construct(EntityManagerInterface $entityManager,
                                $entityName)
    {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
    }

    /**
     * @param mixed $id
     * @return EntityInterface | null
     */
    public function fetch($id)
    {
        return $this->entityManager->find($this->entityName, $id);
    }
}
