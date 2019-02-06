<?php

namespace App\Application\Repository;

use App\Application\Entity\Product;
use App\Application\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    const ENTITY_CLASS = Product::class;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, self::ENTITY_CLASS);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(int $id): Product
    {
        $product = $this->find($id);
        if(!$product) {
            throw new EntityNotFoundException(self::ENTITY_CLASS, $id);
        }

        return $product;
    }
}
