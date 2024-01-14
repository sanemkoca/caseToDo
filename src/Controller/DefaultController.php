<?php

namespace App\Controller;

use App\Context\AssignStrategyContext;
use App\Entity\DeveloperEntity;
use App\Repository\DeveloperEntityRepository;
use App\Repository\TaskEntityRepository;
use App\Services\TaskService;
use App\Strategy\StrategySameLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(DeveloperEntityRepository $developerEntityRepository, TaskEntityRepository $taskEntityRepository): Response
    {
        $developers = $developerEntityRepository->findAll();
        $tasks = $taskEntityRepository->findAll();

        $sameLevelStrategy = new StrategySameLevel($tasks, $developers);
        $strategyContext = new AssignStrategyContext($sameLevelStrategy);

        $plan = $strategyContext->handle();

        return $this->render('default/index.html.twig', [
            'plans' => $plan,
        ]);
    }
}
