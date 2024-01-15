<?php

namespace App\Controller;

use App\Context\AssignStrategyContext;
use App\Entity\DeveloperEntity;
use App\Repository\DeveloperEntityRepository;
use App\Repository\TaskEntityRepository;
use App\Services\TaskService;
use App\Strategy\StrategyInterface;
use App\Strategy\StrategyOverTime;
use App\Strategy\StrategySameLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default', methods: ['GET', 'POST'])]
    public function index(
        Request                   $request,
        DeveloperEntityRepository $developerEntityRepository,
        TaskEntityRepository      $taskEntityRepository): Response
    {
        $developers = $developerEntityRepository->findAll();
        $tasks = $taskEntityRepository->findAll();

        $selectedStrategy = $request->request->get('strategy');

        if ($selectedStrategy == 'StrategySameLevel') {
            $sameLevelStrategy = new StrategySameLevel($tasks, $developers);
            $strategy = $sameLevelStrategy;
        } else{
            $overTimeStrategy = new StrategyOverTime($tasks, $developers);
            $strategy = $overTimeStrategy;
        }
        $strategyContext = new AssignStrategyContext($strategy);

        $plans = $strategyContext->handle();

        return $this->render('default/index.html.twig', [
            'plans' => $plans,
        ]);
    }
}
