<?php


require 'Math.php';

class RSA
{

    private $p = null, $q = null, $z = null, $n = null, $e = null, $d = null;
    private $propertiesAsArray = [];
//
//    public function __construct($p, $q)
//    {
//        $this->p = $p;
//        $this->q = $q;
//        $this->n = Math::multiply($this->p, $this->q);
//        $this->z = Math::calculateZ($this->p, $this->q);
//    }


    public function setProperties(array $session)
    {
        $this->parseSessionToProperties($session);
    }

    public function getD(): int
    {
        return $this->d;
    }

    public function setE(int $e)
    {
        $this->e = $e;
    }

    public function getE()
    {
        return $this->e;
    }

    public function setP(int $p)
    {
        $this->p = $p;
    }

    public function setQ(int $q)
    {
        $this->q = $q;
    }

    public function generateN()
    {
        $this->n = Math::multiply($this->p, $this->q);
    }

    public function generateZ()
    {
        $this->z = Math::calculateZ($this->p, $this->q);
    }

    public function getN(): int
    {
        return $this->n;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    public function checkIfIsRelativelyPrime(int $e): bool
    {
        return (Math::relativelyPrime($e, $this->z));
    }

    public function generateD(): int
    {
        $isValidAndMultiple = (is_numeric($this->d)) ? true : false;

        $sumZ = $this->z;

        while (!$isValidAndMultiple) {
            $number = ($sumZ) + 1;
            $isValidAndMultiple = false;
            if (Math::isMultiple($number, $this->e)) {
                $d = Math::divide($number, $this->e);
                if (!in_array($d, $this->propertiesAsArray)) {
                    $isValidAndMultiple = true;
                    $this->d = $d;
                }
            }
            $sumZ += $this->z;
        }
        return $this->d;
    }

    public function encrypt(){

    }

    public function checkPQZNEToGenerateD(array $session)
    {
        $this->parseSessionToProperties($session);
        $hasDuplicated = false;
        unset($session['d']);
        foreach ($session as $key => $value) {
            if ($keyFinded = array_search($value, $session)) {
                if ($keyFinded !== $key)
                    $hasDuplicated = true;
            }
        }
    }

    private function parseSessionToProperties(array $session)
    {
        foreach ($session as $key => $value) {
            $this->$key = $value;
        }
        $this->propertiesAsArray = ['p' => $this->p, 'q' => $this->q, 'z' => $this->z, 'n' => $this->n, 'e' => $this->e, 'd' => $this->d];
    }

    public
    function getKeyPair()
    {
        return json_encode(['public_key' => [$this->e, $this->n], 'private_key' => [$this->d, $this->n]]);
    }
}