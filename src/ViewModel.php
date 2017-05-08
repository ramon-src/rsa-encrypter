<?php
session_start();
require 'RSA.php';

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if (!in_array($p, $_SESSION['RSA'])) {
        $_SESSION['RSA']['p'] = $p;
        die(json_encode(['status' => true, 'p' => $p]));
    } else {
        die(json_encode(['status' => false, 'message' => 'Valor de P já foi alocado, por favor escolha outro.']));
    }
}

if (isset($_GET['q'])) {
    $q = $_GET['q'];
    if (!in_array($q, $_SESSION['RSA'])) {
        $_SESSION['RSA']['q'] = $q;
        die(json_encode(['status' => true, 'p' => $_SESSION['RSA']['p'], 'q' => $q]));
    } else {
        die(json_encode(['status' => false, 'message' => 'Valor de Q já foi alocado, por favor escolha outro.']));
    }
}

if (isset($_GET['genNZ'])) {
    if ($_SESSION['RSA']['p'] !== '' && $_SESSION['RSA']['q'] !== '') {
        $rsa = new RSA();
        $rsa->setP((int)$_SESSION['RSA']['p']);
        $rsa->setQ((int)$_SESSION['RSA']['q']);
        $rsa->generateN();
        $rsa->generateZ();

        $n = $rsa->getN();
        if (!in_array($n, $_SESSION['RSA'])) {
            $_SESSION['RSA']['n'] = $n;
        } else {
            die(json_encode(['status' => false, 'message' => 'Valor gerado para N já está alocado, por favor escolha p ou q novamente.']));
        }
        $z = $rsa->getZ();
        if (!in_array($z, $_SESSION['RSA'])) {
            $_SESSION['RSA']['z'] = $z;
        } else {
            die(json_encode(['status' => false, 'message' => 'Valor gerado para Z já está alocado, por favor escolha p ou q novamente.']));
        }
        die(json_encode(['status' => true, 'n' => $n, 'z' => $z]));
    }
}

if (isset($_GET['e'])) {
    $e = $_GET['e'];
    if (!in_array($e, $_SESSION['RSA'])) {
        $_SESSION['RSA']['e'] = $e;
        die(json_encode(['status' => true, 'e' => $_SESSION['RSA']['e']]));
    } else {
        die(json_encode(['status' => false, 'message' => 'Valor de E já foi alocado, por favor escolha outro.']));
    }
}

if(isset($_GET['genD'])){
    $rsa = new RSA();
    $rsa->setProperties($_SESSION['RSA']);
    $d = $rsa->generateD();
    $_SESSION['RSA']['d'] = $d;
    die(json_encode(['status' => true, 'd' => $d]));
}

if(isset($_GET['encryptMessage'])){
    $rsa = new RSA();
    $rsa->setProperties($_SESSION['RSA']);
    //$rsa->setM(68);
    $messageCrypted = $rsa->encryptText($_GET['encryptMessage']);
    //$value = $rsa->encrypt();
    die(json_encode(['status' => true, 'message' => "$messageCrypted"]));
}

if(isset($_GET['decryptMessage'])){
    $rsa = new RSA();
    $rsa->setProperties($_SESSION['RSA']);
    //$rsa->setC(68);
    $messageDecrypted = $rsa->decryptText($_GET['decryptMessage']);
    //$value = $rsa->decrypt();
    die(json_encode(['status' => true, 'message' => "$messageDecrypted"]));
}

if(isset($_GET['clean'])){
    $_SESSION['RSA'] = [];
}