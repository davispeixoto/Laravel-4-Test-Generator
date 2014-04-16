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
		$strClassStructure = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'class.txt');
		$strMethods = '';
		$strProviders = '';
		$strMethodWithData = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'methodWithDataProvider.txt');
		$strMethodNoData = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'methodWithoutDataProvider.txt');
		$strMethodProviders = $file->get(__DIR__ . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'provider.txt');
		if (!$file->exists($savePath . DIRECTORY_SEPARATOR . 'data') || !$file->isDirectory($savePath . DIRECTORY_SEPARATOR . 'data')) {
            $file->makeDirectory($savePath . DIRECTORY_SEPARATOR . 'data' , 0775);
        }

		//compose replacing placeholders with data
        foreach ($methods as $method) {
            if($this->isValidMethod($method , $className)) {
                $params = $method->getParameters();
                $paramsArray = array();
                if (!empty($params)) {
                    foreach($params as $param) {
                        $paramsArray[] = '$' . $param->name;
                    }

                    $csvFileName = $className . '.' . ucfirst($method->name);
                    $fullCsvFileName = $csvFileName . '.csv';
                    $methodArgs = join(' , ', $paramsArray);

                    $placeholders = array('{{className}}' , '{{methodName}}' , '{{methodNameLowerCase}}' , '{{methodArgs}}');
                    $replacements = array($className , ucfirst($method->name) , $method->name , $methodArgs);
                    $strMethods .= str_replace($placeholders, $replacements, $strMethodWithData);

                    $placeholders = array('{{className}}' , '{{methodName}}' , '{{methodNameLowerCase}}' , '{{csvFileName}}');
                    $replacements = array($className , ucfirst($method->name) , $method->name , $csvFileName);
                    $strProviders .= str_replace($placeholders, $replacements, $strMethodProviders);

                    $file->put($savePath . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $fullCsvFileName, '');
                } else {
                    $placeholders = array('{{className}}' , '{{methodNameLowerCase}}' , '{{methodName}}');
                    $replacements = array($className , $method->name , ucfirst($method->name));

                    $strMethods .= str_replace($placeholders, $replacements, $strMethodNoData);
                }
            }
        }

		$placeholders = array('{{className}}' , '{{methods}}' , '{{providers}}');
		$replacements = array($className , $strMethods , $strProviders);
		$strClassStructure = str_replace($placeholders, $replacements, $strClassStructure);

		$outputFile = $savePath . DIRECTORY_SEPARATOR . $className . 'Test.php';

		$file->put($outputFile, $strClassStructure);
		$status = $file->exists($outputFile) && ($file->size($outputFile) > 0);

		return $status;
    }

    private function isValidMethod(\ReflectionMethod $method , $className) {
        if(
            $method->class == $className
                &&
            !$method->isConstructor()
                &&
            !$method->isDestructor()
        ) {
            return true;
        } else {
            return false;
        }
    }
} 