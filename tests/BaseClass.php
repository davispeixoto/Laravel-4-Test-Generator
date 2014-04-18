<?php
/**
 * Created by PhpStorm.
 * User: Davis Peixoto
 * Date: 16/04/2014
 * Time: 19:48 PM
 */

class BaseClass {
    const BAR = 'BAR';

    public $bfo;
    protected $bza;
    private $bba;

    public static $boo;
    protected static $baa;
    private static $bzz;

    public function noParamsMethodShouldNotExist()
    {
        //asd
    }

    public function withParamsMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }

    protected function noParamsProtectedMethodShouldNotExist()
    {
        //asd
    }

    protected function withParamsProtectedMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }

    private function noParamsPrivateMethodShouldNotExist()
    {
        //asd
    }

    private function withParamsPrivateMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }

    public static function noParamsStaticMethodShouldNotExist()
    {
        //asd
    }

    public static function withParamsStaticMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }

    protected static function noParamsProtectedStaticMethodShouldNotExist()
    {
        //asd
    }

    protected static function withParamsProtectedStaticMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }

    private static function noParamsPrivateStaticMethodShouldNotExist()
    {
        //asd
    }

    private static function withParamsPrivateStaticMethodShouldNotExist($param1 , $param2)
    {
        //asd
    }
} 