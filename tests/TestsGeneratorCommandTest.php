<?php

class TestsGeneratorCommandTest extends TestCase
{
	public function testGenerateClass()
	{
		$this->call('generate:tests TestGeneratorSampleClass');
		
		$output_dir = app_path() . '/tests/';
		$output_data_dir = app_path() . '/tests/data/';
		
		$this->assertFileExists($output_dir . 'TestGeneratorSampleClassTest.php'); //Output class
		$this->assertFileEquals(__DIR__ . '/TestGeneratorSampleClassExpectedOutput.php' , $output_dir . 'TestGeneratorSampleClassTest.php');
		$this->assertFileExists($output_data_dir . 'TestGeneratorSampleClass.withParamsMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
		$this->assertFileExists($output_data_dir . 'TestGeneratorSampleClass.withParamsStaticMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
	}
	
	public function tearDown()
	{
		parent::tearDown();
		
		$output_dir = app_path() . '/tests/';
		$output_data_dir = app_path() . '/tests/data/';
		
		unlink($output_dir . 'TestGeneratorSampleClassTest.php');
		unlink($output_data_dir . 'TestGeneratorSampleClass.withParamsMethod.csv');
		unlink($output_data_dir . 'TestGeneratorSampleClass.withParamsStaticMethod.csv');
	}
}
?>