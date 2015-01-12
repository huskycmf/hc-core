<?php
namespace HcCore\Stdlib\Extractor;

use Doctrine\ORM\EntityManagerInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as Hydrator;
use Zf2Libs\Stdlib\Extractor\ExtractorInterface;
use Zf2Libs\Stdlib\Extractor\Exception\InvalidArgumentException;

class SimpleEntity implements ExtractorInterface
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
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($entity)
    {
        if (get_class($entity) !== $this->entityName &&
            in_array($this->entityName, class_implements($entity))) {
            throw new InvalidArgumentException("Expected ".$this->entityName." type, but ".get_class($entity)."  type given");
        }

        $data = new Hydrator($this->entityManager);

        $localExtractor = function ($item) use (&$localExtractor, $data){
            if (is_object($item)) {
                if ($item instanceof \DateTime) {
                    return $item->format('Y-m-d H:i:s');
                } else if (in_array('getId', get_class_methods($item))) {
                    return $item->getId();
                } else {
                    return null;
                }
            } else {
                return $item;
            }
        };

        return array_map($localExtractor, $data->extract($entity));
    }
}
