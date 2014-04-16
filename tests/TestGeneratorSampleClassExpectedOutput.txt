<?php
class TestGeneratorSampleClassTest extends TestCase
{
	/**
	 * Tests TestGeneratorSampleClass::noParamsMethod
	 */
	public function testNoParamsMethod()
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::withParamsMethod
	 *
	 * @dataProvider providerWithParamsMethod
	 */
	public function testWithParamsMethod($param1 , $param2)
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::noParamsStaticMethod
	 */
	public function testNoParamsStaticMethod()
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Tests TestGeneratorSampleClass::withParamsStaticMethod
	 *
	 * @dataProvider providerWithParamsStaticMethod
	 */
	public function testWithParamsStaticMethod($param1 , $param2)
	{
		//@TODO implement test{{methodName}} body
	}
	
	/**
	 * Data provider function for TestGeneratorSampleClass::withParamsMethod
	 */
	public function providerWithParamsMethod()
	{
		return $this->dataProvider('TestGeneratorSampleClass.withParamsMethod.csv');
	}
	
	/**
	 * Data provider function for TestGeneratorSampleClass::withParamsStaticMethod
	 */
	public function providerWithParamsStaticMethod()
	{
		return $this->dataProvider('TestGeneratorSampleClass.withParamsStaticMethod.csv');
	}
}