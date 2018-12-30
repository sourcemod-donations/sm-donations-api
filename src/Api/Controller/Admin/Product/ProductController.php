<?php

namespace App\Api\Controller\Admin\Product;

use App\Application\Command\Product\CreateProductCommand;
use App\Application\Command\Product\EditProductCommand;
use App\Application\Entity\Product;
use App\Application\Entity\Server;
use App\Application\Repository\ProductRepository;
use App\Application\Service\Product\CreateProductService;
use App\Application\Service\Product\EditProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var CreateProductService */
    private $createProductService;

    /** @var EditProductService */
    private $editProductService;

    public function __construct(
        ProductRepository $productRepository,
        CreateProductService $createProductService,
        EditProductService $editProductService
    ) {
        $this->productRepository = $productRepository;
        $this->createProductService = $createProductService;
        $this->editProductService = $editProductService;
    }

    /**
     * @Route("/products/{id}", methods={"GET"})
     */
    public function show(int $id)
    {
        $product = $this->productRepository->get($id);

        return new JsonResponse($this->serializeProduct($product), Response::HTTP_OK);
    }

    /**
     * @Route("/products", methods={"POST"})
     */
    public function create(CreateProductCommand $command)
    {
        $product = $this->createProductService->__invoke($command);

        return new JsonResponse($this->serializeProduct($product), Response::HTTP_CREATED);
    }

    /**
     * @Route("/products/{productId}", methods={"PUT"})
     */
    public function edit(EditProductCommand $command)
    {
        $product = $this->editProductService->__invoke($command);

        return new JsonResponse($this->serializeProduct($product), Response::HTTP_ACCEPTED);
    }

    private function serializeProduct(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'servers' => array_map(function (Server $server) {
                return [
                    'id' => $server->getId(),
                    'name' => $server->getName()
                ];
            }, $product->getServers()->toArray())
        ];
    }
}
