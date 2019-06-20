<?php

namespace StrawKit\Framework\Commands;

use SebastianBergmann\Timer\Timer;
use StrawKit\Framework\Executioner;
use StrawKit\Framework\Locators\ClassLocator;
use StrawKit\Framework\Locators\MethodLocator;
use StrawKit\Framework\Reporter;
use StrawKit\Framework\TestCase;
use Symfony\Component\ClassLoader\ClassMapGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    protected function configure()
    {
        $this->setName('run');
        $this->setDescription('Run the tests');
        $this->addArgument('path', InputArgument::OPTIONAL, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        require_once getcwd() . '/vendor/autoload.php';

        $path = $this->path($input);

        foreach (ClassLocator::list($path) as $class) {
            foreach (MethodLocator::list($class) as $method) {
                Executioner::execute($class, $method);
            }
        }

        $output->writeln(Timer::resourceUsage());
    }

    public function path(InputInterface $input)
    {
        if ($path = $input->getArgument('path')) {
            return getcwd() . '/' . $path;
        }

        return getcwd();
    }
}