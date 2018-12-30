<?php

namespace App\Application\Command\Server;

use App\Infrastructure\Contract\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CreateServerCommand implements RequestDtoInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }
}
