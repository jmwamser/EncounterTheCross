<?php

namespace App\Tools\MageTools\Task\Release\Zip;

use Mage\Task\AbstractTask;
use Mage\Task\Exception\ErrorException;
use Symfony\Component\Process\Process;

class PrepareTask extends AbstractTask
{
    public function getName(): string
    {
        return 'release/zip/prepare';
    }

    public function getDescription(): string
    {
        return '[Deploy] Preparing Zip file';
    }

    public function execute(): bool
    {
        if (!$this->runtime->getEnvOption('releases', false)) {
            throw new ErrorException('This task is only available with releases enabled', 40);
        }

        $zipLocal = $this->runtime->getEnvOption(
            'zip_local',
            './tools/Releases/ETC_'
        );
        if ($zipLocal) {
            $zipLocal .= 'v'.$this->runtime->getReleaseId().'_b'.date('YmdHi');
        }
        $this->runtime->setVar('zip_local', $zipLocal ?? $this->runtime->getTempFile());

        $excludes = $this->getExcludes();
        $tarPath = $this->runtime->getEnvOption('zip_create_path', 'zip');
        $flags = $this->runtime->getEnvOption(
            'zip_create',
            $this->runtime->isWindows() ? '' : '-r'
        );
        $from = $this->runtime->getEnvOption('from', './');

        if ($this->runtime->getEnvOption('copyDirectory', false)) {
            $from = sprintf('-C %s ./', $from);
        }

        $cmdTar = sprintf('%s %s %s %s %s', $tarPath, $flags, $zipLocal.'.zip', $from, $excludes);

        /** @var Process $process */
        $process = $this->runtime->runLocalCommand($cmdTar, 300);

        return $process->isSuccessful();
    }

    protected function getExcludes(): string
    {
        $excludes = $this->runtime->getMergedOption('exclude', []);
        $excludes = array_merge(['*.git*', '*.idea*', '*.DS_Store', '*.zip'], array_filter($excludes));

        foreach ($excludes as &$exclude) {
            $exclude = '-x "'.$exclude.'"';
        }

        return implode(' ', $excludes);
    }
}
