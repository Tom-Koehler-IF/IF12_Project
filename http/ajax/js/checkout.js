function createOrder() {
    function resultHandler() {
        // TODO: redirect correctly
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
       first_name1: inputs[0].value,
       last_name: inputs[1].value,
       postal_code: inputs[2].value,
       city: inputs[3].value,
       street: inputs[4].value,
       street_number: inputs[5].value,
    });

    ajax_fetch('/ajax/order.php', 'POST', {
        'Content-Type': 'application/x-www-form-urlencoded'
    }, params.toString())
        .then(r => r.text())
        .then(resultHandler) // TODO: Go to summary page
        .catch(console.error);
}
