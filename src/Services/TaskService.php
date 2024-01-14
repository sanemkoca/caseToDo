<?php

namespace App\Services;

use App\Provider\TaskProvider;

class TaskService
{
    protected array $resolvedProviders = [];

    public function __construct(protected array $providers)
    {
        $this->resolveProviders();
    }

    public function resolveProviders(): void
    {
        foreach ($this->providers as $providerOptions) {
            $this->resolvedProviders[] = new TaskProvider($providerOptions);
        }
    }

    public function getProviders(): array
    {
        return $this->resolvedProviders;
    }

    public function parseTasks(): array
    {
        $tasks = [];
        /** @var TaskProvider $provider */
        foreach ($this->getProviders() as $provider) {
            $tasks[] = $provider->getTasks();
        }

        return collect($tasks)->collapse()->toArray();
    }
}