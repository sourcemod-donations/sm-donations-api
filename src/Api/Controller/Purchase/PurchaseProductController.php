<?php

namespace App\Api\Controller\Purchase;

use App\Api\Controller\AbstractController;
use App\Application\Command\Purchase\PurchaseProductCommand;
use App\Application\Service\Purchase\PurchaseProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseProductController extends AbstractController
{
    /** @var PurchaseProductService */
    private $purchaseProductService;

    public function __construct(PurchaseProductService $purchaseProductService)
    {
        $this->purchaseProductService = $purchaseProductService;
    }

    /**
     * @Route("/purchase", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
        $command = new PurchaseProductCommand(
            $request->request->getInt('productId'),
            $request->request->getInt('recipientSteamId'),
            $this->getUserId()
        );
        $purchase = $this->purchaseProductService->__invoke($command);

        return new JsonResponse([
            'id' => $purchase->getId()
        ], Response::HTTP_CREATED);
    }
}
