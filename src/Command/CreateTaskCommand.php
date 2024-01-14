<?php

namespace App\Command;

use App\Entity\TaskEntity;
use App\Services\TaskService;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-task',
    description: 'Create a task',
    hidden: true
)]
class CreateTaskCommand extends Command
{
    public function __construct(protected TaskService $taskService, protected ManagerRegistry $registry)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $tasks = $this->taskService->parseTasks();

            foreach ($tasks as $task) {
                $this->registry->getManager()->persist($task);
            }

            $this->registry->getManager()->flush();

            $io->success('Tasks created successfully!');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}