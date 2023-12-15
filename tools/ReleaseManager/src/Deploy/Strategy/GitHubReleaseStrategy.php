<?php

namespace App\Tools\MageTools\Deploy\Strategy;

use Mage\Deploy\Strategy\StrategyInterface;
use Mage\Runtime\Exception\RuntimeException;
use Mage\Runtime\Runtime;

class GitHubReleaseStrategy implements StrategyInterface
{
    protected Runtime $runtime;

    public function getName(): string
    {
        return 'GHRelease';
    }

    public function setRuntime(Runtime $runtime): void
    {
        $this->runtime = $runtime;
    }

    public function getPreDeployTasks(): array
    {
        $this->checkStage(Runtime::PRE_DEPLOY);
        $tasks = $this->runtime->getTasks();

        return $tasks;
    }

    public function getOnDeployTasks(): array
    {
        $this->checkStage(Runtime::ON_DEPLOY);
        $tasks = $this->runtime->getTasks();

        return $tasks;
    }

    public function getOnReleaseTasks(): array
    {
        return [];
    }

    public function getPostReleaseTasks(): array
    {
        return [];
    }

    public function getPostDeployTasks(): array
    {
        $this->checkStage(Runtime::POST_DEPLOY);
        $tasks = $this->runtime->getTasks();

        return $tasks;
    }

    /**
     * Check the runtime stage is correct.
     *
     * @throws RuntimeException
     */
    private function checkStage(string $stage): void
    {
        if ($this->runtime->getStage() !== $stage) {
            throw new RuntimeException(sprintf('Invalid stage, got "%s" but expected "%s"', $this->runtime->getStage(), $stage));
        }
    }
}
