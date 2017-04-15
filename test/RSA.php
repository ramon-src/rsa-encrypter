<?php

require 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use \App\RSA as RSAClass;


class RSA extends TestCase
{
    public $rsa;

    protected function setUp()
    {
        $this->rsa = new RSAClass(3, 13);
    }

    public function testCalcNNeedsToResultIn39()
    {
        $this->assertEquals(39, $this->rsa->getN());
    }

    public function testCalcZNeedsToResultIn24()
    {
        $this->assertEquals(24, $this->rsa->getZ());
    }

    public function testEisARelativePrimeByZ()
    {
        $this->assertTrue($this->rsa->checkIfIsRelativelyPrime(5));
    }

    public function testGetTheMultipleByZAndEWhichIsNotEqualOthersVariables()
    {
        /**
         * In this case 25/5 is 5 but E is already defined by 5 so 145/5 is the first multiple valid
         * resulting in 49
         */
        $this->rsa->setE(5);
        $d = $this->rsa->generateD();
        $this->assertEquals(29, $d);
    }

    public function testGetJsonKeyPair()
    {
        $this->rsa->setE(5);
        $this->rsa->generateD();

        $expectedJson = json_encode([
            'public_key' => [$this->rsa->getE(), $this->rsa->getN()],
            'private_key' => [$this->rsa->getD(), $this->rsa->getN()]
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, $this->rsa->getKeyPair());

    }

}