<?php

// src/Command/CreateUserCommand.php

namespace App\Command;

use App\Service\HuidigeBevragingenService;
use App\Service\IndividueleBevragingenService;
use App\Service\KadasterService;
use App\Service\LoadExtractService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExtractCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('app:extract:load')
        // the short description shown while running "php bin/console list"
        ->setDescription('Loads an BAG extract into the database')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command loads an BAG extract into the database as fallback for when the BAG APIs are down')
        ->setDescription('This command loads an BAG extract into the database as fallback for when the BAG APIs are down');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $extractService = new LoadExtractService($this->entityManager, $io);
        $extractService->loadNummerObjecten();
    }
}
