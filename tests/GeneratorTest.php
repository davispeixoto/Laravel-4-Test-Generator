<?php
use Davispeixoto\TestGenerator\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $generator;
    protected static $output_dir;
    protected static $output_data_dir;

    public function __construct()
    {
        $this->generator = new Generator();
        self::$output_dir = __DIR__ . DIRECTORY_SEPARATOR;
        self::$output_data_dir = self::$output_dir . 'data'  . DIRECTORY_SEPARATOR;
    }

	public function testGenerate()
	{
        $this->generator->generate('TestGeneratorSampleClass' , self::$output_dir);
		$this->assertFileExists(self::$output_dir . 'TestGeneratorSampleClassTest.php'); //Output class
		$this->assertFileEquals(__DIR__ . '/TestGeneratorSampleClassExpectedOutput.php' , self::$output_dir . 'TestGeneratorSampleClassTest.php');
		$this->assertFileExists(self::$output_data_dir . 'TestGeneratorSampleClass.WithParamsMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
		$this->assertFileExists(self::$output_data_dir . 'TestGeneratorSampleClass.WithParamsStaticMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
	}

    /**
     * @expectedException \Exception
     */
    public function testException()
    {
        $this->generator->generate('DoNotExistForTesting' , self::$output_dir);
    }

	public static function tearDownAfterClass()
	{
        unlink(self::$output_dir . 'TestGeneratorSampleClassTest.php');
        unlink(self::$output_data_dir . 'TestGeneratorSampleClass.WithParamsMethod.csv');
        unlink(self::$output_data_dir . 'TestGeneratorSampleClass.WithParamsStaticMethod.csv');
        rmdir(self::$output_data_dir);
	}
}