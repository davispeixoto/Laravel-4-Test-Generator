<?php

class TestGeneratorSampleClassTest extends TestCase
{
    /**
     * Tests TestGeneratorSampleClass::noParamsMethod
     */
    public function testNoParamsMethod()
    {
        //@TODO implement testNoParamsMethod body
    }

    /**
     * Tests TestGeneratorSampleClass::withParamsMethod
     *
     * @dataProvider providerWithParamsMethod
     */
    public function testWithParamsMethod($param1, $param2)
    {
        //@TODO implement testWithParamsMethod body
    }

    /**
     * Tests TestGeneratorSampleClass::noParamsStaticMethod
     */
    public function testNoParamsStaticMethod()
    {
        //@TODO implement testNoParamsStaticMethod body
    }

    /**
     * Tests TestGeneratorSampleClass::withParamsStaticMethod
     *
     * @dataProvider providerWithParamsStaticMethod
     */
    public function testWithParamsStaticMethod($param1, $param2)
    {
        //@TODO implement testWithParamsStaticMethod body
    }


    /**
     * Data provider function for TestGeneratorSampleClass::withParamsMethod
     */
    public function providerWithParamsMethod()
    {
        return $this->dataProvider('TestGeneratorSampleClass.WithParamsMethod.csv');
    }

    /**
     * Data provider function for TestGeneratorSampleClass::withParamsStaticMethod
     */
    public function providerWithParamsStaticMethod()
    {
        return $this->dataProvider('TestGeneratorSampleClass.WithParamsStaticMethod.csv');
    }


}