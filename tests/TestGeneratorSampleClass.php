<?php
class TestGeneratorSampleClass extends BaseController 
{
	const FOO = 'FOO';
	
	public $foo;
	protected $bar;
	private $baz;
	
	public static $foos;
	protected static $bars;
	private static $bazs;
	
	public function noParamsMethod()
	{
		//asd
	}
	
	public function withParamsMethod($param1 , $param2)
	{
		//asd
	}
	
	protected function noParamsProtectedMethod()
	{
		//asd
	}
	
	protected function withParamsProtectedMethod($param1 , $param2)
	{
		//asd
	}
	
	private function noParamsPrivateMethod()
	{
		//asd
	}
	
	private function withParamsPrivateMethod($param1 , $param2)
	{
		//asd
	}
	
	public static function noParamsStaticMethod()
	{
		//asd
	}
	
	public static function withParamsStaticMethod($param1 , $param2)
	{
		//asd
	}
	
	protected static function noParamsProtectedStaticMethod()
	{
		//asd
	}
	
	protected static function withParamsProtectedStaticMethod($param1 , $param2)
	{
		//asd
	}
	
	private static function noParamsPrivateStaticMethod()
	{
		//asd
	}
	
	private static function withParamsPrivateStaticMethod($param1 , $param2)
	{
		//asd
	}
}
?>