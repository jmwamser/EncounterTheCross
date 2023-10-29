<?php

namespace App\Tools\MageTools\Task\Yarn;

use Symfony\Component\Process\Process;

class BuildTask extends AbstractYarnTask
{
    public function getName(): string
    {
        return 'yarn/build';
    }

    public function getDescription(): string
    {
        return '[Yarn] Build';
    }

    public function execute(): bool
    {
        $options = $this->getOptions();
        $cmd = sprintf('yarn %s %s',$options['buildType'], $options['flags']);

        /** @var Process $process */
        $process = $this->runtime->runCommand(trim($cmd), intval($options['timeout']));

        return $process->isSuccessful();
    }

    protected function getYarnOptions(): array
    {
        return ['flags' => '--non-interactive','buildType'=>'dev'];
    }
}