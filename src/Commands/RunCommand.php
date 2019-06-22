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
use Symfony\Component\Yaml\Yaml;

class RunCommand extends Command
{
    protected $config;

    protected function configure()
    {
        $this->setName('run');
        $this->setDescription('Run the tests');
        $this->addArgument('path', InputArgument::REQUIRED, 'path to tests');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        require_once getcwd() . '/vendor/autoload.php';

        $path = $this->path($input);

        foreach (ClassLocator::list($path) as $class) {
            foreach (MethodLocator::list($class) as $method) {
                Executioner::execute($class, $method, $this->config());
            }
        }

        $output->writeln(Timer::resourceUsage());
    }

    public function path(InputInterface $input)
    {
        return getcwd() . '/' . $input->getArgument('path');
    }

    /**
     * Load config from local file.
     *
     * @return array
     */
    public function config(): array
    {
        if (!is_null($this->config)) {
            return $this->config;
        }

        if (file_exists($config = getcwd() . '/strawkit.yml')) {
            $this->config = Yaml::parseFile($config);
        } else {
            $this->config = [];
        }

        return $this->config;
    }
}