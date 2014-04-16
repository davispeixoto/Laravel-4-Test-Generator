<?php
use Davispeixoto\TestGenerator\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $generator;
    protected $output_dir;
    protected $output_data_dir;

    public function setUp()
    {
        parent::setUp();
        $this->generator = new Generator();
        $this->output_dir = app_path() . '/tests/';
        $this->output_data_dir = app_path() . '/tests/data/';
    }

	public function testGenerate()
	{
        $this->generator->generate('TestGeneratorSampleClass' , $this->output_dir);
        $this->assertInstanceOf('Generator' , $this->generator);
		$this->assertFileExists($this->output_dir . 'TestGeneratorSampleClassTest.php'); //Output class
		$this->assertFileEquals(__DIR__ . '/TestGeneratorSampleClassExpectedOutput.php' , $this->output_dir . 'TestGeneratorSampleClassTest.php');
		$this->assertFileExists($this->output_data_dir . 'TestGeneratorSampleClass.withParamsMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
		$this->assertFileExists($this->output_data_dir . 'TestGeneratorSampleClass.withParamsStaticMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
	}

    /**
     * @expectedException \Exception
     */
    public function testException()
    {
        $this->generator->generate('DoNotExistForTesting' , $this->output_dir);
    }

	public function tearDown()
	{
        unlink($this->output_dir . 'TestGeneratorSampleClassTest.php');
        unlink($this->output_data_dir . 'TestGeneratorSampleClass.withParamsMethod.csv');
        unlink($this->output_data_dir . 'TestGeneratorSampleClass.withParamsStaticMethod.csv');
		parent::tearDown();
	}
}