<?php

namespace App\Application\Service\Product;

use App\Application\Command\Product\CreateProductCommand;
use App\Application\Entity\Product;
use App\Application\Repository\ServerRepository;
use App\Application\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class CreateProductService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ServerRepository */
    private $serverRepository;

    public function __construct(
        EntityManagerInterface $em,
        ServerRepository $serverRepository
    ) {
        $this->em = $em;
        $this->serverRepository = $serverRepository;
    }

    public function __invoke(CreateProductCommand $dto): Product
    {
        $this->validCommandOrThrow($dto);

        $product = new Product();
        $product
            ->setName($dto->name)
            ->setPrice($dto->price);

        $product->getServers()->clear();
        array_walk($dto->servers, function (int $id) use ($product) {
            $product->addServer(
                $this->serverRepository->find($id)
            );
        });

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}
