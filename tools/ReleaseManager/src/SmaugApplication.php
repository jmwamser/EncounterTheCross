<?php

namespace App\Tools\MageTools;

use App\Tools\MageTools\Command\ZipCommand;
use Mage\Command\AbstractCommand;
use Mage\MageApplication;
use z4kn4fein\SemVer\Version;

class SmaugApplication extends MageApplication
{
    public function __construct(string $file)
    {
        parent::__construct($file);
        $this->setVersion(Version::parse(Smaug::VERSION));
        $this->setName(sprintf(
            'Smaug (%s)',
            Smaug::CODENAME
        ));
    }

    protected function loadBuiltInCommands(): void
    {
        parent::loadBuiltInCommands();

        $this->loadCommands([ZipCommand::class]);
    }

    /**
     * Load the provided commands.
     */
    protected function loadCommands(array $commands)
    {
        foreach ($commands as $command) {
            /** @var AbstractCommand $instance */
            $instance = new $command();
            $instance->setRuntime($this->runtime);

            $this->add($instance);
        }
    }
}
