<?php

namespace App\Tools\MageTools\Task\Yarn;

use Mage\Task\AbstractTask;

abstract class AbstractYarnTask extends AbstractTask
{
    /**
     * @return string[]
     */
    protected function getOptions(): array
    {
        $options = array_merge(
            ['path' => 'yarn'],
            $this->getYarnOptions(),
            $this->runtime->getMergedOption('yarn'),
            $this->options
        );

        return $options;
    }

    /**
     * @return array<string, string|int>
     */
    protected function getYarnOptions(): array
    {
        return ['timeout' => 120];
    }
}
