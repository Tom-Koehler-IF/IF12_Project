<?php
session_start();

require_once __DIR__ . '/repository/login.php';

// If this page is opened we just logout
if (getCurrentUser() != null) logout();
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">

  <!--Webseite Title-->
  <title>Login</title>

  <!--Bootstrap CSS-->
  <link href="bootstrap.min.css" rel="stylesheet"/>
</head>

<body>
  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!--Main Background-->
  <!--Login Box-->
  <style>
    body {
      background-color: #87807f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-box {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
      width: 400px;
      height: 475px;
    }

    input[type="text"]:focus {
      outline: none;
      box-shadow: 0 0 5px #87807f;
      border-color: #87807f;
    }

    input[type="password"]:focus {
      outline: none;
      box-shadow: 0 0 5px #87807f;
      border-color: #87807f;
    }

    .input-error {
      border-color: red;
      box-shadow: 0 0 5px red;
    }
  </style>

  <!--Login content-->
  <div class="login-box">
    <!--Main Text-->
    <span
      style="display: block; text-align: center; font-weight: bold; font-size: 30px; margin-top: 5px;">Anmeldung</span>

    <!--Enter Username-->
    <div style="margin-bottom: 30px; margin-top: 30px;">
      <span>Benutzername</span>
      <input type="text" class="form-control" id="benutzername" maxlength="30">
    </div>

    <!--Enter Password-->
    <div style="margin-bottom: 60px;">
      <span>Passwort</span>
      <input type="password" class="form-control" id="passwort" maxlength="30">
    </div>

    <!--Login Button-->
    <div style="text-align: center;">
      <button id="login_button" style="width: 225px;" class="btn btn-success"
        onclick="validateLoginForm()">Anmelden</button>
    </div>

    <div style="text-align: center; margin-top: 60px; font-weight: bold;">
      <span>Noch keinen Account, <a id="navigate_to_register_form" href="Register.php">hier</a> Registrieren</span>
    </div>
  </div>

  <?php require_once('./ajax/ajax.js.php') ?>
  <!--Login validation script for inputs above-->
  <script>
    function validateLoginForm() {
      function loginHandler(result) {
        if (result) alert(result);
        else window.location.href = "index.php";
      }

      let inputs = document.querySelectorAll(".form-control");
      let isValid = true;
      inputs.forEach((input) => {
        if (input.value.trim() === "") {
          input.classList.add("input-error");
          isValid = false;
        } else {
          input.classList.remove("input-error");
        }
      });

      if (!isValid) {
        alert("Bitte füllen sie alle Felder aus!");
        return;
      }

      let username = inputs[0].value;
      let password = inputs[1].value;

      ajax_fetch(`/ajax/login.php?username=${username}&password=${password}`, 'GET')
        .then(r => r.text())
        .then(loginHandler)
        .catch(console.error);
    }
  </script>
</body>

</html>
