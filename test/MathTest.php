<?php


class MathTest extends PHPUnit_Framework_TestCase
{
    public $rsa;

    public function test9And12isNotRelativelyPrimes()
    {
        $this->assertFalse(Math::relativelyPrime(9, 12));
    }

    public function test9And10IsRelativelyPrimes()
    {
        $this->assertTrue(Math::relativelyPrime(9, 10));
    }

    public function testIfPrimeNumbersAreReturnedCorrectly()
    {
        $expectedPrimeNumbers = [0 => 2, 1 => 3, 2 => 5, 3 => 7];
        $this->assertEquals($expectedPrimeNumbers, Math::getPrimeNumbersBefore(8));
    }

    public function testGetFactoringNumbers()
    {
        $expectedPrimeNumbers = [0 => 2, 1 => 3];
        $this->assertEquals($expectedPrimeNumbers, Math::mmc(24));
    }

    public function test10433IsPrime()
    {
        $this->assertTrue(Math::isPrime(102929));
    }

    public function test8IsNotPrime()
    {
        $this->assertFalse(Math::isPrime(8));
    }

    public function testGetBinaryArrayContaining0111()
    {
        $expectedArray = [
            0 => 0,
            1 => 1,
            2 => 1,
            3 => 1
        ];
        $this->assertEquals($expectedArray, Math::getBinaryArrayFromRest(14));
    }
}