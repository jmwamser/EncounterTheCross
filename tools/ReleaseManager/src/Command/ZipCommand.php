<?php

namespace App\Tools\MageTools\Command;

use App\Tools\MageTools\Deploy\Strategy\GitHubReleaseStrategy;
use Mage\Command\AbstractCommand;
use Mage\Runtime\Exception\RuntimeException;
use Mage\Runtime\Runtime;
use Mage\Task\Exception\ErrorException;
use Mage\Task\Exception\SkipException;
use Mage\Task\ExecuteOnRollbackInterface;
use Mage\Task\TaskFactory;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ZipCommand extends AbstractCommand
{
    protected function configure(): void
    {
        $this
            ->setName('gh-release')
            ->setDescription('Create Release with source code zip')
            ->addArgument('environment', InputArgument::REQUIRED, 'Name of the environment to connect to')
            ->addArgument('version', InputArgument::REQUIRED, 'Version Number to use.')
            ->addOption(
                'branch',
                null,
                InputOption::VALUE_REQUIRED,
                'Force to switch to a branch other than the one defined.',
                false
            )
            ->addOption(
                'tag',
                null,
                InputOption::VALUE_REQUIRED,
                'Deploys a specific tag.',
                false
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->requireConfig();

        $output->writeln('Starting <fg=bright-red>Smaug</>');
        $output->writeln('');

        try {
            $this->runtime->setEnvironment($input->getArgument('environment'));

            //            $strategy = $this->runtime->guessStrategy();
            $strategy = new GitHubReleaseStrategy();
            $strategy->setRuntime($this->runtime);

            $this->taskFactory = new TaskFactory($this->runtime);

            $output->writeln(sprintf('    Environment: <fg=green>%s</>', $this->runtime->getEnvironment()));
            $this->log(sprintf('Environment: %s', $this->runtime->getEnvironment()));

            if ($this->runtime->getEnvOption('releases', false)) {
                //                $this->runtime->generateReleaseId();
                // TODO build in the sem version lib here
                $this->runtime->setReleaseId($input->getArgument('version'));
                $output->writeln(sprintf('    Release ID: <fg=green>%s</>', $this->runtime->getReleaseId()));
                $this->log(sprintf('Release ID: %s', $this->runtime->getReleaseId()));
            }

            if ($this->runtime->getConfigOption('log_file', false)) {
                $output->writeln(sprintf('    Logfile: <fg=green>%s</>', $this->runtime->getConfigOption('log_file')));
            }

            $output->writeln(sprintf('    Strategy: <fg=green>%s</>', $strategy->getName()));

            if ((false !== $input->getOption('branch')) && (false !== $input->getOption('tag'))) {
                throw new RuntimeException('Branch and Tag options are mutually exclusive.');
            }

            if (false !== $input->getOption('branch')) {
                $this->runtime->setEnvOption('branch', $input->getOption('branch'));
            }

            if (false !== $input->getOption('tag')) {
                $this->runtime->setEnvOption('branch', false);
                $this->runtime->setEnvOption('tag', $input->getOption('tag'));
                $output->writeln(sprintf('    Tag: <fg=green>%s</>', $this->runtime->getEnvOption('tag')));
            }

            if ($this->runtime->getEnvOption('branch', false)) {
                $output->writeln(sprintf('    Branch: <fg=green>%s</>', $this->runtime->getEnvOption('branch')));
            }

            $output->writeln('');

            // Run "Pre Deploy" Tasks
            $this->runtime->setStage(Runtime::PRE_DEPLOY);
            if (!$this->runTasks($output, $strategy->getPreDeployTasks())) {
                throw $this->getException();
            }

            //            // Run "On Deploy" Tasks
            //            $this->runtime->setStage(Runtime::ON_DEPLOY);
            //            $this->runOnHosts($output, $strategy->getOnDeployTasks());
            //
            //            // Run "On Release" Tasks
            //            $this->runtime->setStage(Runtime::ON_RELEASE);
            //            $this->runOnHosts($output, $strategy->getOnReleaseTasks());
            //
            //            // Run "Post Release" Tasks
            //            $this->runtime->setStage(Runtime::POST_RELEASE);
            //            $this->runOnHosts($output, $strategy->getPostReleaseTasks());

            // Run "Post Deploy" Tasks
            $this->runtime->setStage(Runtime::POST_DEPLOY);
            if (!$this->runTasks($output, $strategy->getPostDeployTasks())) {
                throw $this->getException();
            }
        } catch (RuntimeException $exception) {
            $output->writeln('');
            $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));
            $output->writeln('');
            $this->statusCode = 7;
        }

        $output->writeln('Finished <fg=bright-red>Smaug</>');

        return intval($this->statusCode);
    }

    /**
     * Runs all the tasks.
     *
     * @param string[] $tasks
     *
     * @throws RuntimeException
     */
    protected function runTasks(OutputInterface $output, array $tasks): bool
    {
        if (0 == count($tasks)) {
            $output->writeln(
                sprintf('    No tasks defined for <fg=black;options=bold>%s</> stage', $this->getStageName())
            );
            $output->writeln('');

            return true;
        }

        if (null !== $this->runtime->getHostName()) {
            $output->writeln(
                sprintf(
                    '    Starting <fg=black;options=bold>%s</> tasks on host <fg=black;options=bold>%s</>:',
                    $this->getStageName(),
                    $this->runtime->getHostName()
                )
            );
        } else {
            $output->writeln(sprintf('    Starting <fg=black;options=bold>%s</> tasks:', $this->getStageName()));
        }

        $totalTasks = count($tasks);
        $succeededTasks = 0;

        foreach ($tasks as $taskName) {
            $task = $this->taskFactory->get($taskName);
            $output->write(sprintf('        Running <fg=magenta>%s</> ... ', $task->getDescription()));
            $this->log(sprintf('Running task %s (%s)', $task->getDescription(), $task->getName()));

            if ($this->runtime->inRollback() && !$task instanceof ExecuteOnRollbackInterface) {
                ++$succeededTasks;
                $output->writeln('<fg=yellow>SKIPPED</>');
                $this->log(
                    sprintf(
                        'Task %s (%s) finished with SKIPPED, it was in a Rollback',
                        $task->getDescription(),
                        $task->getName()
                    )
                );
            } else {
                try {
                    if ($task->execute()) {
                        ++$succeededTasks;
                        $output->writeln('<fg=green>OK</>');
                        $this->log(
                            sprintf('Task %s (%s) finished with OK', $task->getDescription(), $task->getName())
                        );
                    } else {
                        $output->writeln('<fg=red>FAIL</>');
                        $this->statusCode = 180;
                        $this->log(
                            sprintf('Task %s (%s) finished with FAIL', $task->getDescription(), $task->getName())
                        );
                    }
                } catch (SkipException $exception) {
                    ++$succeededTasks;
                    $output->writeln('<fg=yellow>SKIPPED</>');
                    $this->log(
                        sprintf(
                            'Task %s (%s) finished with SKIPPED, thrown SkipException',
                            $task->getDescription(),
                            $task->getName()
                        )
                    );
                } catch (ErrorException $exception) {
                    $output->writeln(sprintf('<fg=red>ERROR</> [%s]', $exception->getTrimmedMessage()));
                    $this->log(
                        sprintf(
                            'Task %s (%s) finished with FAIL, with Error "%s"',
                            $task->getDescription(),
                            $task->getName(),
                            $exception->getMessage()
                        )
                    );
                    $this->statusCode = 190;
                }
            }

            if (0 !== $this->statusCode) {
                break;
            }
        }

        $alertColor = 'red';
        if ($succeededTasks == $totalTasks) {
            $alertColor = 'green';
        }

        $output->writeln(
            sprintf(
                '    Finished <fg=%s>%d/%d</> tasks for <fg=black;options=bold>%s</>.',
                $alertColor,
                $succeededTasks,
                $totalTasks,
                $this->getStageName()
            )
        );
        $output->writeln('');

        return $succeededTasks == $totalTasks;
    }

    /**
     * Exception for halting the the current process.
     */
    protected function getException(): RuntimeException
    {
        return new RuntimeException(
            sprintf('Stage "%s" did not finished successfully, halting command.', $this->getStageName()),
            50
        );
    }
}
