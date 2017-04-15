<?php
namespace App;


final class Math
{
    static function multiply(int ...$numbers): int
    {
        return array_product($numbers);
    }

    static function calculateZ(int ...$numbers): int
    {
        return ($numbers[0] - 1) * ($numbers[1] - 1);
    }

    static function relativelyPrime($a, $b): bool
    {
        while ($b != 0) {
            $t = $a;
            $a = $b;
            $b = $t % $b;
        }
        return ($a > 1) ? false : true;
    }

    static function isMultiple($a, $b): bool
    {
        return ($a % $b == 0);
    }

    static function divide($a, $b)
    {
        return $a / $b;
    }

    /**
     * Sieve of Eratosthenes
     * @param int $limit
     * @return array
     */
    static function getPrimeNumbersBefore(int $limit)
    {
        for ($i = 2; $i < $limit; $i++) {
            $primes[$i] = true;
        }
        for ($n = 2; $n < $limit; $n++) {
            if ($primes[$n]) {
                for ($i = $n * $n; $i < $limit; $i += $n) {
                    $primes[$i] = false;
                }
            }
        }
        while ($key = array_search(false, $primes)) {
            unset($primes[$key]);
        }
        return array_keys($primes);
    }

    static function isPrime(int $number): bool
    {
        if ($number == 2)
            return true;
        if ($number == 3)
            return true;
        if ($number % 2 == 0)
            return false;
        if ($number % 3 == 0)
            return false;
        $i = 5;
        $w = 2;
        while ($i * $i <= $number) {
            if ($number % $i == 0)
                return false;
            $i += $w;
            $w = 6 - $w;
        }
        return true;
    }

    static function getFactoringNumbers(int $number)
    {
        if (self::isPrime($number)) // implement the is_prime() function yourself
            --$number; // Subtract to get an even number, which is not a prime

        $candidates = array();  // Numbers that may fit.

        $top_search = $number / 2; // Limits the useless search for candidates

        for ($i = 1; $i < $top_search; ++$i) {
            if ($number % $i == 0)
                $candidates[$i] = $number / $i;
        }
        return $candidates;
    }

    static function mmc($a, $b)
    {
        if ($b == 0)
            return $a;
        else
            return mmc($b, $a % $b);
    }


}