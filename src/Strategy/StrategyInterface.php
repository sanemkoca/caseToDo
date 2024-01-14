<?php

namespace App\Strategy;

interface StrategyInterface
{
    public function __construct(array $tasks, array $developers);

    public function execute(): array;
}