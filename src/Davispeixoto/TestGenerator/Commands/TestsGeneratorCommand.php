<?php namespace Davispeixoto\TestGenerator\Commands;

use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TestsGeneratorCommand extends Command {

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
	
	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		//instantiate the class reflector
		$reflector = NULL;
		$className = $this->argument('name');
		
		try {
			$reflector = new \ReflectionClass($className);	
		} catch (\Exception $e) {
			$this->error($e->getMessage());
			$this->error($e->getTraceAsString());
			exit(1);
		}
		
		//get methods
		$methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
		
		//start filesystem stuff
		$file = new File();
		$str_class = $file->get(__DIR__.'/../Templates/class.txt');
		$str_methods = '';
		$str_providers = '';
		$str_methods_data_provider_placeholder = $file->get(__DIR__.'/../Templates/methodWithDataProvider.txt');
		$str_methods_no_data_provider_placeholder = $file->get(__DIR__.'/../Templates/methodWithoutDataProvider.txt');
		$str_providers_placeholder = $file->get(__DIR__.'/../Templates/provider.txt');
		$savePath = $this->option('path');
		if (!$file->exists($savePath . '/data') || !$file->isDirectory($savePath . '/data')) {
			$file->makeDirectory($savePath . '/data' , 775);
		} 
		
		
		
		//compose replacing placeholders with data
		foreach ($methods as $key => $method) {
			if(
				$method->class == $className 
					&& 
				!$method->isConstructor() 
					&& 
				!$method->isDestructor()
			) {
				$params = $method->getParameters();
				$params_array = array();
				if (!empty($params)) {
					foreach($params as $innerKey => $param) {
						$params_array[] = '$' . $param->name;
					}
					
					$csvFileName = $className . '.' . ucfirst($method->name);
					$fullCsvFileName = $csvFileName . '.csv';
					$methodArgs = join(' , ', $params_array);
					
					$placeholders = array('{{className}}' , '{{methodName}}' , '{{methodArgs}}');
					$replacements = array($className , ucfirst($method->name) , $methodArgs);
					$str_methods .= str_replace($placeholders, $replacements, $str_methods_data_provider_placeholder);
					
					$placeholders = array('{{className}}' , '{{methodName}}' , '{{csvFileName}}');
					$replacements = array($className , ucfirst($method->name) , $csvFileName);
					$str_providers .= str_replace($placeholders, $replacements, $str_providers_placeholder);
					
					$file->put($savePath . '/data/' . $fullCsvFileName, '');
				} else {
					$placeholders = array('{{className}}' , '{{methodName}}');
					$replacements = array($className , ucfirst($method->name));
					
					$str_methods .= str_replace($placeholders, $replacements, $str_methods_no_data_provider_placeholder);
				}
			}
		}
		
		$placeholders = array('{{className}}' , '{{methods}}' , '{{providers}}');
		$replacements = array($className , $str_methods , $str_providers);
		$str_class = str_replace($placeholders, $replacements, $str_class);
		
		$outputFile = $savePath . '/' . $className . 'Test.php';
		
		$file->put($outputFile, $str_class);
		$success = $file->exists($outputFile) && ($file->size($outputFile) > 0);
		
		if ($success) {
			return $this->info("Created {$outputFile}");
		}
		 
		$this->error("Could not create {$outputFile}");
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