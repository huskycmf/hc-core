<?php
namespace HcCore\Service;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\EntityInterface;
use HcCore\Service\ResourceCommandInterface;
use Zf2Libs\Stdlib\Service\Response\Messages\Response;

class DeleteService implements ResourceCommandInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Response
     */
    protected $serviceResponse;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Response $serviceResponse
     */
    public function __construct(EntityManagerInterface $entityManager,
                                Response $serviceResponse)
    {
        $this->entityManager = $entityManager;
        $this->serviceResponse = $serviceResponse;
    }

    /**
     * @param EntityInterface $entityToRemove
     * @return Response
     */
    public function execute(EntityInterface $entityToRemove)
    {
        try {
            $this->entityManager->beginTransaction();

            $this->entityManager->remove($entityToRemove);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            return $this->serviceResponse->error($e->getMessage());
        }

        return $this->serviceResponse->success();
    }
}
