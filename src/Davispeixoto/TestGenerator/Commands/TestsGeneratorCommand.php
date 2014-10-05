<?php namespace Davispeixoto\TestGenerator\Commands;

use Davispeixoto\TestGenerator\Generator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TestsGeneratorCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tests:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a PHPUnit/Laravel Test class skeleton.';

    protected $generator;

    public function __construct()
    {
        parent::__construct();
        $this->generator = new Generator();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        try {
            if ($this->generator->generate($this->argument('name'), $this->option('path'))) {
                $this->info('Test class for ' . $this->argument('name') . ' successfully generated!');
            } else {
                $this->error('Could not generate test class for ' . $this->argument('name') . '. Check writing permissions');
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $this->error($e->getTraceAsString());
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'Name of the class you want the test skeleton.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('path', null, InputOption::VALUE_OPTIONAL, 'Path to output tests directory.', app_path() . '/tests'),
        );
    }
}

?>