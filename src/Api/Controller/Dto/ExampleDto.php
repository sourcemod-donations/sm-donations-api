<?php

namespace App\Api\Controller\Dto;

use App\Infrastructure\Contract\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ExampleDto implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank()
     */
    public $property;

    public function __construct(Request $request)
    {
        $bag = $request->request;
        $this->property = $bag->get('property');
    }
}
