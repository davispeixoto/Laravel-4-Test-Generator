<?php
use Davispeixoto\TestGenerator\Generator;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    protected $generator;
    protected static $outputDir;
    protected static $outputDataDir;

    public function __construct()
    {
        $this->generator = new Generator();
        self::$outputDir = __DIR__ . DIRECTORY_SEPARATOR;
        self::$outputDataDir = self::$outputDir . 'data' . DIRECTORY_SEPARATOR;
    }

    public function testGenerate()
    {
        $this->generator->generate('TestGeneratorSampleClass', self::$outputDir);
        $this->assertFileExists(self::$outputDir . 'TestGeneratorSampleClassTest.php'); //Output class
        $this->assertFileEquals(__DIR__ . '/TestGeneratorSampleClassExpectedOutput.php',
            self::$outputDir . 'TestGeneratorSampleClassTest.php');
        $this->assertFileExists(self::$outputDataDir . 'TestGeneratorSampleClass.WithParamsMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
        $this->assertFileExists(self::$outputDataDir . 'TestGeneratorSampleClass.WithParamsStaticMethod.csv'); //CSV file for TestGeneratorSampleClass::withParamsStaticMethod
    }

    /**
     * @expectedException \Exception
     */
    public function testException()
    {
        $this->generator->generate('DoNotExistForTesting', self::$outputDir);
    }

    public static function tearDownAfterClass()
    {
        unlink(self::$outputDir . 'TestGeneratorSampleClassTest.php');
        unlink(self::$outputDataDir . 'TestGeneratorSampleClass.WithParamsMethod.csv');
        unlink(self::$outputDataDir . 'TestGeneratorSampleClass.WithParamsStaticMethod.csv');
        rmdir(self::$outputDataDir);
    }
}