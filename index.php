<?php
session_start();
if (!isset($_SESSION['RSA'])) {
    $_SESSION['RSA'] = [
        'e' => '',
        'n' => '',
        'd' => '',
        'z' => '',
        'p' => '',
        'q' => '',
    ];
} else {
    print_r($_SESSION['RSA']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teste</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        ...
    </div>
</nav>

<div class="container" >
    <div class="row">
        <div class="col-lg-12">
            <form id="form" name="rsa">
                <input id="p" type="text" name="p">

                <input id="q" type="text" name="q">

                <input id="e" type="text" name="e">
                
                <button id="genNZ">genNZ</button>
                <button id="genD">genD</button>
                <button id="clean">Clean</button>

                <textarea id="messageToCrypt" name="messageToCrypt"></textarea>
                <button id="encrypt">Encrypt</button>

                <div id="messageCrypted"></div>

                <textarea id="messageToDecrypt" name="messageToDecrypt"></textarea>
                <button id="decrypt">Decrypt</button>

                <div id="messageDecrypted"></div>
            </form>
        </div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
var env = ['xampp', 'linux'];

env['xampp'] = 'http://localhost/rsa-encrypter';
    env['linux'] = 'http://localhost:8080';
    $('input').on('change', function (e) {
        e.preventDefault();
        var attrName = $(this).attr('name'),
            val = $(this).val();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?" + attrName + "=" + val,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
    });

    $('#genNZ').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?genNZ  ",
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
    });
    $('#genD').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?genD  ",
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
    });
     $('#encrypt').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?encryptMessage="+$('textarea#messageToCrypt').val(),
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#messageCrypted').text(JSON.stringify(response.message));
            }
        });
    });
    $('#decrypt').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?decryptMessage="+$('textarea#messageToDecrypt').val(),
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#messageDecrypted').text(JSON.stringify(response.message));
            }
        });
    });
    $('#clean').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: env['xampp']+"/src/ViewModel.php?clean  ",
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });
    });
</script>
</body>
</html>
