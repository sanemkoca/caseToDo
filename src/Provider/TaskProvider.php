<?php

namespace App\Provider;

use App\Entity\TaskEntity;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TaskProvider
{
    public function __construct(
        protected array $options,
    )
    {
    }

    public function getClient(): HttpClientInterface
    {
        return HttpClient::createForBaseUri($this->options['base_url']);
    }

    public function getEndpoint(): string
    {
        return $this->options['endpoint'];
    }

    public function getMethod(): string
    {
        return $this->options['method'] ?? 'GET';
    }

    protected function getResults(): array
    {
        $client = $this->getClient();
        $response = $client->request($this->getMethod(), $this->getEndpoint());
        return $response->toArray();
    }

    public function getTasks(): array
    {
        $tasks = [];
        foreach ($this->getResults() as $rawTask) {
            $task = new TaskEntity();
            $task->setTitle($rawTask[$this->getMapping('title')]. ' - ' . $this->options['name']);
            $task->setDifficulty($rawTask[$this->getMapping('difficulty')]);
            $task->setDuration($rawTask[$this->getMapping('duration')]);

            $tasks[] = $task;
        }

        return $tasks;
    }

    protected function getMapping(?string $key = null): array|string
    {
        if ($key) {
            return $this->options['mapping'][$key];
        }

        return $this->options['mapping'];
    }
}