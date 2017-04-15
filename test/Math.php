<?php

require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use \App\Math as MathClass;


class Math extends TestCase
{
    public $rsa;


    public function test9And12isNotRelativelyPrimes()
    {
        $this->assertFalse(MathClass::relativelyPrime(9, 12));
    }

    public function test9And10IsRelativelyPrimes()
    {
        $this->assertTrue(MathClass::relativelyPrime(9, 10));
    }

    public function testIfPrimeNumbersAreReturnedCorrectly()
    {
        $expectedPrimeNumbers = [0 => 2, 1 => 3, 2 => 5, 3 => 7];
        $this->assertEquals($expectedPrimeNumbers, MathClass::getPrimeNumbersBefore(8));
    }

//    public function testGetFactoringNumbers()
//    {
//        $expectedPrimeNumbers = [0 => 2, 1 => 3];
//        print_r(MathClass::getFactoringNumbers(24));
//        $this->assertEquals($expectedPrimeNumbers, MathClass::getFactoringNumbers(24));
//    }

//    public function testGetFactoringNumbers()
//    {
//        $expectedPrimeNumbers = [0 => 2, 1 => 3];
//        $this->assertEquals($expectedPrimeNumbers, MathClass::mmc(24,2));
//    }

    public function test10433IsPrime()
    {
        $this->assertTrue(MathClass::isPrime(102929));
    }

    public function test8IsNotPrime()
    {
        $this->assertFalse(MathClass::isPrime(8));
    }
}