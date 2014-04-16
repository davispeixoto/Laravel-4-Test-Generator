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
		$str_class = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'class.txt');
		$str_methods = '';
		$str_providers = '';
		$str_methods_data_provider_placeholder = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'methodWithDataProvider.txt');
		$str_methods_no_data_provider_placeholder = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'methodWithoutDataProvider.txt');
		$str_providers_placeholder = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'provider.txt');
		if (!$file->exists($savePath . DIRECTORY_SEPARATOR . 'data') || !$file->isDirectory($savePath . DIRECTORY_SEPARATOR . 'data')) {
            $file->makeDirectory($savePath . DIRECTORY_SEPARATOR . 'data' , 775);
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

                    $csvFileName = $className . '.' . ucfirst($method->name);
                    $fullCsvFileName = $csvFileName . '.csv';
                    $methodArgs = join(' , ', $params_array);

                    $placeholders = array('{{className}}' , '{{methodName}}' , '{{methodNameLowerCase}}' , '{{methodArgs}}');
                    $replacements = array($className , ucfirst($method->name) , $method->name , $methodArgs);
                    $str_methods .= str_replace($placeholders, $replacements, $str_methods_data_provider_placeholder);

                    $placeholders = array('{{className}}' , '{{methodName}}' , '{{methodNameLowerCase}}' , '{{csvFileName}}');
                    $replacements = array($className , ucfirst($method->name) , $method->name , $csvFileName);
                    $str_providers .= str_replace($placeholders, $replacements, $str_providers_placeholder);

                    $file->put($savePath . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $fullCsvFileName, '');
                } else {
                    $placeholders = array('{{className}}' , '{{methodNameLowerCase}}' , '{{methodName}}');
                    $replacements = array($className , $method->name , ucfirst($method->name));

                    $str_methods .= str_replace($placeholders, $replacements, $str_methods_no_data_provider_placeholder);
                }
            }
        }

		$placeholders = array('{{className}}' , '{{methods}}' , '{{providers}}');
		$replacements = array($className , $str_methods , $str_providers);
		$str_class = str_replace($placeholders, $replacements, $str_class);

		$outputFile = $savePath . DIRECTORY_SEPARATOR . $className . 'Test.php';

		$file->put($outputFile, $str_class);
		$status = $file->exists($outputFile) && ($file->size($outputFile) > 0);

		return $status;
    }
} 