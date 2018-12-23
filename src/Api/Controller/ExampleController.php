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
        $unused='nonPSR2Syntax';
        $unused='nonPSR2Syntax';
        no t ph p c o d e

        return new JsonResponse('ok');
    }
}
