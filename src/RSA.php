<?php


require 'Math.php';

class RSA
{
    private $p = null, $q = null, $z = null, $n = null, $e = null, $d = null, $m = null, $c = null;
    private $propertiesAsArray = [];

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

    public function setC(int $c)
    {
        $this->c = $c;
    }

    public function getC()
    {
        return $this->c;
    }
    public function setM(int $m)
    {
        $this->m = $m;
    }

    public function getM()
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

    public function getN(): int
    {
        return $this->n;
    }

    public function getZ(): int
    {
        return $this->z;
    }

    public function generateN()
    {
        $this->n = Math::multiply($this->p, $this->q);
    }

    public function generateZ()
    {
        $this->z = Math::calculateZ($this->p, $this->q);
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
    public function decryptText(string $message): string{
        $letters = explode(" ", $message);
        $messageDecrypted = [];
        foreach($letters as $letter){
            $this->setC($letter);
            $messageDecrypted[] = $this->decrypt();
        }
        return implode(' ', $messageDecrypted);
    }
    public function decrypt()
    {
        $binaries = Math::getBinaryArrayFromRest($this->getD());
        $n = $this->getN();
        $keyMemoryValue = [];
        $keysToEliminate = [];
        foreach ($binaries as $key => $binary) {
            if (!$binary) {
                $keysToEliminate[] = $key;
            }
            if ($key == 0) {
                $value = fmod($this->c, $n);
                $keyMemoryValue[$key] = $value;
            } elseif ($key > 0) {
                end($keyMemoryValue);
                if (key($keyMemoryValue) == $key - 1) {
                    $currentValue = current($keyMemoryValue);
                    $value = fmod(pow($currentValue, 2),$n);
                    $keyMemoryValue[$key] = $value;
                }
            }
        }
        foreach ($keysToEliminate as $key) {
            unset($keyMemoryValue[$key]);
        }
        reset($keyMemoryValue);
        $productOfValues = 1;
        foreach ($keyMemoryValue as $value) {
            $productOfValues *= $value;
        }
        return fmod($productOfValues, $n);
    }
    
    public function encryptText(string $message): string{
        $letters = explode(" ", $message);
        $messageCrypted = [];
        foreach($letters as $letter){
            $this->setM($letter);
            $messageCrypted[] = $this->encrypt();
        }
        return implode(' ', $messageCrypted);
    }
public function encrypt()
    {
        $binaries = Math::getBinaryArrayFromRest($this->getE());
        $n = $this->getN();
        $keyMemoryValue = [];
        $keysToEliminate = [];
        foreach ($binaries as $key => $binary) {
            if (!$binary) {
                $keysToEliminate[] = $key;
            }
            if ($key == 0) {
                $value = fmod($this->m, $n);
                $keyMemoryValue[$key] = $value;
            } elseif ($key > 0) {
                end($keyMemoryValue);
                if (key($keyMemoryValue) == $key - 1) {
                    $currentValue = current($keyMemoryValue);
                    $value = fmod(pow($currentValue, 2),$n);
                    $keyMemoryValue[$key] = $value;
                }
            }
        }
        foreach ($keysToEliminate as $key) {
            unset($keyMemoryValue[$key]);
        }
        reset($keyMemoryValue);
        $productOfValues = 1;
        foreach ($keyMemoryValue as $value) {
            $productOfValues *= $value;
        }
        return fmod($productOfValues, $n);
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