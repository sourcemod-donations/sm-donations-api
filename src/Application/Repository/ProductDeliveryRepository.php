<?php

namespace App\Application\Repository;

use App\Application\Entity\ProductDelivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductDelivery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductDelivery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductDelivery[]    findAll()
 * @method ProductDelivery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDeliveryRepository extends ServiceEntityRepository
{
    const ENTITY_CLASS = ProductDelivery::class;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, self::ENTITY_CLASS);
    }
}
