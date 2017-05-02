<?php

namespace App;

class RSA
{
    private $p = null, $q = null, $z = null, $n = null, $e = null, $d = null;

    public function __construct($p, $q)
    {
        $this->p = $p;
        $this->q = $q;
        $this->n = Math::multiply($this->p, $this->q);
        $this->z = Math::calculateZ($this->p, $this->q);
    }

    public function getD(): int
    {
        return $this->d;
    }

    public function setE(int $e)
    {
        $this->e = $e;
    }

    public function getE(): int
    {
        return $this->e;
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

        $numbers = ['p' => $this->p, 'q' => $this->q, 'z' => $this->z, 'n' => $this->n, 'e' => $this->e, 'd' => $this->d];
        $sumZ = $this->z;

        while (!$isValidAndMultiple) {
            $number = ($sumZ) + 1;
            $isValidAndMultiple = false;
            if (Math::isMultiple($number, $this->e)) {
                $d = Math::divide($number, $this->e);
                if (!in_array($d, $numbers)) {
                    $isValidAndMultiple = true;
                    $this->d = $d;
                }
            }
            $sumZ += $this->z;
        }
        return $this->d;
    }

    public function getKeyPair()
    {
        return json_encode(['public_key' => [$this->e, $this->n], 'private_key' => [$this->d, $this->n]]);
    }
}