<?php

namespace App\Api\Controller\ServerApi;

use App\Application\Entity\ProductDelivery;
use App\Application\Entity\SmPluginProductDelivery;
use App\Application\Repository\ProductDeliveryRepository;
use App\Application\Repository\SmPluginProductDeliveryRepository;
use App\Application\Service\ProductDelivery\ApiConsumeProductDeliveryStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CheckPurchasesController extends AbstractController
{
    /** @var SmPluginProductDeliveryRepository */
    private $deliveryRepository;

    public function __construct(SmPluginProductDeliveryRepository $deliveryRepository)
    {
        $this->deliveryRepository = $deliveryRepository;
    }

    /**
     * @Route("/purchases/{steamId}")
     */
    public function getPurchases(int $steamId)
    {
        $deliveries = $this->deliveryRepository->findBy([
            'steamId' => $steamId
        ]);

        return new JsonResponse(array_map([$this, 'serialize'], $deliveries));
    }

    private function serialize(SmPluginProductDelivery $delivery)
    {
        return [
            'id' => $delivery->getId(),
            'steamId' => $delivery->getSteamId(),
            'product' => $delivery->getProductDelivery()->getProductDeliveryConfiguration()
        ];
    }
}
