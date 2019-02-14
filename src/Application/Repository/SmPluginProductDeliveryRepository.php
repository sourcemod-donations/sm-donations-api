<?php

namespace App\Application\Repository;

use App\Application\Entity\SmPluginProductDelivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmPluginProductDelivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmPluginProductDelivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmPluginProductDelivery[]    findAll()
 * @method SmPluginProductDelivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmPluginProductDeliveryRepository extends ServiceEntityRepository
{
    const ENTITY_CLASS = SmPluginProductDelivery::class;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, self::ENTITY_CLASS);
    }
}
