<?php

namespace Trappar\AliceGeneratorBundle\Persister;

use Doctrine\Common\Persistence\ManagerRegistry;
use Trappar\AliceGenerator\Persister\DoctrinePersister as BaseDoctrinePersister;

class DoctrinePersister extends BaseDoctrinePersister
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine->getManager());
        $this->doctrine = $doctrine;
    }

    protected function getMetadata($object)
    {
        try {
            $class = $this->getClass($object);
            $manager = $this->doctrine->getManagerForClass($class);
            if (null === $manager) {
                throw new \RuntimeException(sprintf('unable to find manager for %s', $class));
            }
            return $manager->getClassMetadata($class);
        } catch (\Exception $e) {
            return false;
        }
    }
}