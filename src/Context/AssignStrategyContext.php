<?php

namespace App\Context;

use App\Strategy\StrategyInterface;

class AssignStrategyContext
{
    public const WORKING_HOURS = 45;
    public const OVERTIME = self::WORKING_HOURS + 3;

    public function __construct(protected StrategyInterface $strategy)
    {
    }

    public function handle(): array
    {
       return $this->strategy->execute();
    }
}