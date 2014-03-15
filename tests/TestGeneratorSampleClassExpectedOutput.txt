<?php
class TestGeneratorSampleClassTest extends TestCase
{
	/**
	 * Tests TestGeneratorSampleClass::noParamsMethod
	 */
	public function testnoParamsMethod()
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::withParamsMethod
	 *
	 * @dataProvider providerwithParamsMethod
	 */
	public function testwithParamsMethod($param1 , $param2)
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::noParamsStaticMethod
	 */
	public function testnoParamsStaticMethod()
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::withParamsStaticMethod
	 *
	 * @dataProvider providerwithParamsStaticMethod
	 */
	public function testwithParamsStaticMethod($param1 , $param2)
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Data provider function for TestGeneratorSampleClass::withParamsMethod
	 */
	public function providerwithParamsMethod()
	{
		return $this->dataProvider('TestGeneratorSampleClass.withParamsMethod.csv');
	}
	
	/**
	 * Data provider function for TestGeneratorSampleClass::withParamsStaticMethod
	 */
	public function providerwithParamsStaticMethod()
	{
		return $this->dataProvider('TestGeneratorSampleClass.withParamsStaticMethod.csv');
	}
}
?>