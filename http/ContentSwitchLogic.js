function loadContent(page) {
    const content = {
        Funny_Dinner_Contest: `
            <div>
                <span style="display: block; font-weight: bold; font-size: 25px;">Monat: Dezember</span>
                <span style="display: block; font-weight: bold; font-size: 25px;">Name: Anonymous</span>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                <button class="btn btn-success" style="border-radius: 50%; width: 75px; height: 75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/arrow_white2.png"></img>
                </button>    
                <img src="Images/Funny_Dinner_Contest_TestIMG.avif" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
                <button class="btn btn-success" style="border-radius: 50%; width: 75px; height: 75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/arrow_white.png"></img>
                </button>
            </div>

            <div style="position: fixed; bottom: 0; right: 0; display: flex; align-items: center; margin-bottom: 15px;">
                <button class="btn btn-success" style="border-radius: 15px; width: 200px; margin-right: 15px;" onclick="loadContent('Funny_Dinner_Contest_Rating')">Go To Rating</button>
                <input class="form-control" type="file" id="formFile" style="margin-right: 15px;">
            </div>
        `,
        Funny_Dinner_Contest_Rating: `
            <div>
                <span style="display: block; font-weight: bold; font-size: 25px;">Rating</span>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 20px;">
                <button class="btn btn-success" style="border-radius: 50%; width: 75px; height: 75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/arrow_white2.png"></img>
                </button>    
                <img src="Images/Funny_Dinner_Contest_TestIMG.avif" style="max-height: 75%; max-width: 75%; height: auto; width: auto;">
                <button class="btn btn-success" style="border-radius: 50%; width: 75px; height: 75px; display: flex; justify-content: center; align-items: center;">
                    <img style="width: 60px; height: 60px;" src="Images/arrow_white.png"></img>
                </button>
            </div>

            <div style="position: fixed; bottom: 0; right: 0;">
                <button class="btn btn-success" style="border-radius: 15px; margin-bottom: 15px; margin-right: 15px;" onclick="loadContent('Funny_Dinner_Contest')">Go To Winners</button>
            </div>
        `,
    };

    if (page == 'Funny_Dinner_Contest' || page == 'Funny_Dinner_Contest_Rating') loadDinnerContest(false);
    else document.getElementById('main-content').innerHTML = content[page];
}

function loadCheckout() {
    document.getElementById('main-content').innerHTML = 'TODO';

    ajax_fetch(`ajax/checkout.php`, 'GET')
        .then(r => r.text())
        .then(t => document.getElementById('main-content').innerHTML = t)
        .catch(alert);
}

function loadProductCategory(category) {
    document.getElementById('main-content').innerHTML = 'TODO';

    ajax_fetch(`/ajax/product.php?category=${category}`, 'GET')
        .then(r => r.text())
        .then(t => document.getElementById('main-content').innerHTML = t)
        .catch(alert);    
}

function loadDinnerContest(winner) {
    document.getElementById('main-content').innerHTML = 'TODO';
    let url = '/ajax/contest.php';
    if (winner) url = url + '?showWinner=1';

    ajax_fetch(url, 'GET')
        .then(r => r.text())
        .then(loadInnerContent)
        .catch(alert);
}

function loadInnerContent(innerHTML) {
    const element = document.getElementById('main-content');
    setInnerHTML(element, innerHTML);
}

function setInnerHTML(elm, html) {
  elm.innerHTML = html;
  
  Array.from(elm.querySelectorAll("script"))
    .forEach( oldScriptEl => {
      const newScriptEl = document.createElement("script");
      
      Array.from(oldScriptEl.attributes).forEach( attr => {
        newScriptEl.setAttribute(attr.name, attr.value) 
      });
      
      const scriptText = document.createTextNode(oldScriptEl.innerHTML);
      newScriptEl.appendChild(scriptText);
      
      oldScriptEl.parentNode.replaceChild(newScriptEl, oldScriptEl);
  });
}

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
