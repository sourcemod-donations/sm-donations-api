<?php

namespace App\Console\Command;

use App\Application\Command\User\CreateUserCommand;
use App\Application\Service\Auth\AuthTokenService;
use App\Application\Service\User\CreateUserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateAuthTokenCommand extends Command
{
    protected static $defaultName = 'app:auth:generate-token';

    /** @var CreateUserService */
    private $createUserService;

    /** @var AuthTokenService */
    private $authTokenService;

    public function __construct(CreateUserService $createUserService, AuthTokenService $authTokenService)
    {
        parent::__construct();
        $this->createUserService = $createUserService;
        $this->authTokenService = $authTokenService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generate a Bearer token for API authentication')
            ->addArgument('steamId', InputArgument::REQUIRED, 'SteamID64 of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $steamId = $input->getArgument('steamId');
        $io = new SymfonyStyle($input, $output);

        $io->title("Generating API token for $steamId");

        $command = new CreateUserCommand((int)$steamId);
        $user = $this->createUserService->__invoke($command);
        $token = $this->authTokenService->generate($user);

        $io->text("Bearer $token");
    }
}
