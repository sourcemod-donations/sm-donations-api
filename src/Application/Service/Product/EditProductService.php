<?php

namespace App\Application\Service\Product;

use App\Application\Command\Product\EditProductCommand;
use App\Application\Entity\Product;
use App\Application\Repository\ProductRepository;
use App\Application\Repository\ServerRepository;
use App\Application\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class EditProductService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ServerRepository */
    private $serverRepository;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(
        EntityManagerInterface $em,
        ServerRepository $serverRepository,
        ProductRepository $productRepository
    ) {
        $this->em = $em;
        $this->serverRepository = $serverRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(EditProductCommand $dto): Product
    {
        $this->validCommandOrThrow($dto);

        $product = $this->productRepository->get($dto->productId);
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
