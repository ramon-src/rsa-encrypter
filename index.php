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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>

  <body>

    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">RSA - Algorithm</a>
        </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-lg-offset-3">

          <form id="form" name="rsa">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="p">Choose P</label>
                  <select id="p" name="p" class="form-control">
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="q">Choose Q</label>
                  <select id="q" name="q" class="form-control">
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="e">Choose E</label>
                  <input id="e" name="e" type="text" class="form-control">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-lg-4">
                <button class="btn btn-primary" id="genNZ">Gen N and Z</button>
              </div>
              <div class="col-lg-4">
                <button class="btn btn-info" id="genD">Gen D</button>
              </div>
              <div class="col-lg-4">
                <button class="btn btn-default" id="clean">Clean</button>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>Message to crypt (please only numbers)</label>
                  <textarea id="messageToCrypt" name="messageToCrypt" class="form-control"></textarea>
                  <button class="btn btn-success pull-right" style="margin-top: 10px;" id="encrypt">Encrypt</button>
                </div>
                <br>
                <div id="messageCrypted"></div>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>Message to decrypt (please only numbers)</label>
                  <textarea id="messageToDecrypt" name="messageToDecrypt" class="form-control"></textarea>
                  <button class="btn btn-success pull-right" style="margin-top: 10px;" id="decrypt">Decrypt</button>
                </div>
                <br>
                <div id="messageDecrypted"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      var env = ['xampp', 'linux'];

      env['xampp'] = 'http://localhost/rsa-encrypter';
      env['linux'] = 'http://localhost:8080';

      $(window).ready(function() {
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?getPrimes",
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            var listprimes;
            var primes = response.primes;
            $.each(JSON.parse(primes), function(index, value) {
              listprimes += "<option value='" + value + "'>" + value + "</option>";
            });
            $('#p').append(listprimes);
            $('#q').append(listprimes);
          }
        });
      });


      $('select, input').on('change', function(e) {
        e.preventDefault();
        var attrName = $(this).attr('name'),
          val = $(this).val();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?" + attrName + "=" + val,
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log(response);
          }
        });
      });

      $('#genNZ').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?genNZ  ",
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log(response);
          }
        });
      });

      $('#genD').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?genD  ",
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log(response);
          }
        });
      });
      $('#encrypt').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?encryptMessage=" + $('textarea#messageToCrypt').val(),
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#messageCrypted').text(JSON.stringify(response.message));
          }
        });
      });
      $('#decrypt').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?decryptMessage=" + $('textarea#messageToDecrypt').val(),
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#messageDecrypted').text(JSON.stringify(response.message));
          }
        });
      });
      $('#clean').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: env['xampp'] + "/src/ViewModel.php?clean  ",
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log(response);
          }
        });
      });
    </script>
  </body>

  </html>