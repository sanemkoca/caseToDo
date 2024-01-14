<?php

namespace App\Strategy;

use App\Context\AssignStrategyContext;
use App\Entity\DeveloperEntity;
use App\Entity\TaskEntity;

class StrategyOverTime implements StrategyInterface
{

    private array $weeklyPlans = [];

    public function __construct(protected array $tasks, protected array $developers)
    {
        $this->initWeeklyPlans();
    }

    public function execute(): array
    {
        foreach ($this->weeklyPlans as $developerId => $developerPlan) {
            /**
             * @var DeveloperEntity $developer
             * @var TaskEntity $task
             */
            $developer = $developerPlan['developer'];
            foreach ($this->tasks as $task) {
                if ($task->getDifficulty() == $developer->getLevel()) {
                    $this->plan($task, $developer);
                }
            }
        }

        return $this->weeklyPlans;
    }

    private function plan(TaskEntity $task, DeveloperEntity $developer, int $week = 1)
    {
        if (!isset($this->weeklyPlans[$developer->getDeveloper()]['weeks'][$week])) {
            $this->weeklyPlans[$developer->getDeveloper()]['weeks'][$week] = [];
        }

        $weekDetails = $this->weeklyPlans[$developer->getDeveloper()]['weeks'][$week];

        if ($developer->taskEffort($task) + $this->calculateOccupiedHours($weekDetails, $developer) > AssignStrategyContext::OVERTIME) {
            return $this->plan($task, $developer, $week + 1);
        }

        $this->weeklyPlans[$developer->getDeveloper()]['weeks'][$week][] = $task;
        // $this->weeklyPlans[$developer->getDeveloper()]['workingHours'][$week] = $this->calculateOccupiedHours($this->weeklyPlans[$developer->getDeveloper()]['weeks'][$week],$developer);
        $this->tasks = collect($this->tasks)->filter(function (TaskEntity $taskInList) use ($task) {
            return $taskInList !== $task;
        })->toArray();
    }


    public function initWeeklyPlans(): void
    {
        /** @var DeveloperEntity $developer */
        foreach ($this->developers as $developer) {
            $this->weeklyPlans[$developer->getDeveloper()] = [
                'developer' => $developer,
                'weeks' => [
                    1 => [],
                ]
            ];
        }
    }

    private function calculateOccupiedHours(array $week, DeveloperEntity $developer)
    {
        return array_sum(array_map(function ($task) use ($developer) {
            return $developer->taskEffort($task);
        }, $week));
    }
}
