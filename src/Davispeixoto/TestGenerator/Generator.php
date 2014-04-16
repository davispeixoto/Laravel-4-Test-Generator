<?php
/**
 * Created by PhpStorm.
 * User: Davis Peixoto
 * Date: 15/04/2014
 */

namespace Davispeixoto\TestGenerator;

use Illuminate\Filesystem\Filesystem as File;

class Generator {
    public function __construct()
    {
        return $this;
    }

    public function generate($className , $savePath)
    {
        //instantiate the class reflector
        $reflector = null;

        try {
            $reflector = new \ReflectionClass($className);
        } catch (\Exception $e) {
            throw $e;
        }

		//get methods
		$methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);

		//start filesystem stuff
		$file = new File();
		$str_class = $file->get(__DIR__.'/Templates/class.txt');
		$str_methods = '';
		$str_providers = '';
		$str_methods_data_provider_placeholder = $file->get(__DIR__.'/Templates/methodWithDataProvider.txt');
		$str_methods_no_data_provider_placeholder = $file->get(__DIR__.'/Templates/methodWithoutDataProvider.txt');
		$str_providers_placeholder = $file->get(__DIR__.'/Templates/provider.txt');
		if (!$file->exists($savePath . '/data') || !$file->isDirectory($savePath . '/data')) {
            $file->makeDirectory($savePath . '/data' , 775);
        }

		//compose replacing placeholders with data
        foreach ($methods as $method) {
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
                    foreach($params as $param) {
                        $params_array[] = '$' . $param->name;
                    }

                    $params_array[] = '$expectedOutput';

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
		$status = $file->exists($outputFile) && ($file->size($outputFile) > 0);

		return $status;
    }
} 