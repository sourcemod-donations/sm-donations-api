<?php

namespace App\Api\Controller;

use App\Api\Controller\Dto\ExampleDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @Route("/example", methods={"POST"})
     * @param ExampleDto $dto
     * @return JsonResponse
     */
    public function __invoke(ExampleDto $dto)
    {
        return new JsonResponse('ok');
    }
}