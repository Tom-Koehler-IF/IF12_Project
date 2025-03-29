<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">

  <!--Webseite Title-->
  <title>Registrierung</title>

  <!--Bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <!--Main Background-->
  <!--Register Box-->
  <style>
    body {
      background-color: #87807f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .register-box {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
      width: 400px;
      height: 675px;
    }

    input[type="text"]:focus {
      outline: none;
      box-shadow: 0 0 5px #87807f;
      border-color: #87807f;
    }

    .input-error {
      border-color: red;
      box-shadow: 0 0 5px red;
    }
  </style>

  <!--Register content-->
  <div class="register-box">
    <!--Main Text-->
    <span
      style="display: block; text-align: center; font-weight: bold; font-size: 22.5px; margin-top: 5px;">Registrierung</span>

    <!--Enter Vorname-->
    <div style="margin-bottom: 3px; margin-top: 5px;">
      <span>Vorname</span>
      <input type="text" class="form-control" id="vorname_register" maxlength="30">
    </div>

    <!--Enter Nachname-->
    <div style="margin-bottom: 3px;">
      <span>Nachname</span>
      <input type="text" class="form-control" id="nachname_register" maxlength="30">
    </div>

    <!--Enter Postleitzahl-->
    <div style="margin-bottom: 3px;">
      <span>Postleitzahl</span>
      <input type="text" class="form-control" id="postleitzahl_register" maxlength="5" inputmode="numeric"
        pattern="[0-9]*" oninput="this.value = this.value.replace(/\D/, '').slice(0, 5);">
    </div>

    <!--Enter Ort-->
    <div style="margin-bottom: 3px;">
      <span>Ort</span>
      <input type="text" class="form-control" id="ort_register" maxlength="40">
    </div>

    <!--Enter Straße-->
    <div style="margin-bottom: 3px;">
      <span>Straße</span>
      <input type="text" class="form-control" id="strasse_register" maxlength="40">
    </div>

    <!--Enter Hausnummer-->
    <div style="margin-bottom: 3px;">
      <span>Hausnummer</span>
      <input type="text" class="form-control" id="hausnummer_register" maxlength="3" inputmode="numeric"
        pattern="[0-9]*" oninput="this.value = this.value.replace(/\D/, '').slice(0, 5);">
    </div>

    <!--Enter Username-->
    <div style="margin-bottom: 3px;">
      <span>Benutzername</span>
      <input type="text" class="form-control" id="benutzername_register" maxlength="30">
    </div>

    <!--Enter Password-->
    <div style="margin-bottom: 15px;">
      <span>Passwort</span>
      <input type="text" class="form-control" id="passwort_register" maxlength="30">
    </div>

    <!--Register Button-->
    <div style="text-align: center; margin-bottom: 7.5px;">
      <button id="register_button" style="width: 225px;" class="btn btn-success"
        onclick="validateForm()">Registrieren</button>
    </div>

    <div style="text-align: center; font-weight: bold;">
      <span>Zurück zur, <a id="navigate_to_login_form" href="Login.html">Anmeldung</a></span>
    </div>
  </div>

  <?php require_once('./ajax/ajax.js.php') ?>
  <!--Validation Script for register inputs above-->
  <script>
    function validateForm() {
      function signupHandler(result) {
        if (result) alert(result);
        else window.location.href = "Login.php";
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
        alert("Bitte füllen sie alle felder aus!");
        return;
      }

      let params = new URLSearchParams({
        first_name: inputs[0].value,
        last_name: inputs[1].value,
        postal_code: inputs[2].value,
        city: inputs[3].value,
        street: inputs[4].value,
        street_number: inputs[5].value,
        username: inputs[6].value,
        password: inputs[7].value,
      });

      ajax_fetch('/ajax/login.php', 'POST', {
        'Content-Type': 'application/x-www-form-urlencoded'
      }, params.toString())
        .then(r => r.text())
        .then(signupHandler)
        .catch(console.error);
    }
  </script>
</body>

</html>
