<?php

namespace App\Tools\MageTools\Task\Yarn;

use Symfony\Component\Process\Process;

class InstallTask extends AbstractYarnTask
{
    public function getName(): string
    {
        return 'yarn/install';
    }

    public function getDescription(): string
    {
        return '[Yarn] Install';
    }

    public function execute(): bool
    {
        $options = $this->getOptions();
        $cmd = sprintf('yarn %s', $options['flags']);

        /** @var Process $process */
        $process = $this->runtime->runCommand(trim($cmd), intval($options['timeout']));

        return $process->isSuccessful();
    }

    protected function getYarnOptions(): array
    {
        return ['flags' => '--non-interactive --no-progress',];
    }
}