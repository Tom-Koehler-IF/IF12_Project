function loadContent(page) {
    const content = {
        Beliebt: '<p>Details for Beliebt link.</p>', 
        Menüs: `
            <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                <div style="border: 1px solid black; margin: 15px; padding: 10px; width: 30%;">
                    <h3 style="font-weight: bold;">Hamburger Menü</h3>
                    <img src="Images/Burger_Menues.png" alt="Burger Menü 1" style="width: 100%;">
                    <p>Preis: 7.99€</p>
                      <details>
                        <summary>Beinhaltet</summary>
                        <ul>
                            <li>Hamburger</li>
                            <li>Pommes</li>
                            <li>Getränk</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Zutaten</summary>
                        <ul>
                            <li>Brot</li>
                            <li>Beef Patty</li>
                            <li>Tomaten</li>
                            <li>Zwiebeln</li>
                            <li>Salat</li>
                            <li>Kartoffeln</li>
                        </ul>
                    </details>
                    <p>Energiewerte: 3138KJ / 750kcal</p>
                    <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
                </div>
                <div style="border: 1px solid black; margin: 15px; padding: 10px; width: 30%;">
                    <h3 style="font-weight: bold;">Cheese Burger Menü</h3>
                    <img src="Images/Burger_Menues.png" alt="Burger Menü 2" style="width: 100%;">
                    <p>Preis: 9.99€</p>
                     <details>
                        <summary>Beinhaltet</summary>
                        <ul>
                            <li>Chesse Burger</li>
                            <li>Pommes</li>
                            <li>Getränk</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Zutaten</summary>
                        <ul>
                            <li>Brot</li>
                            <li>Beef Patty</li>
                            <li>Käse</li>
                            <li>Tomaten</li>
                            <li>Zwiebeln</li>
                            <li>Salat</li>
                            <li>Kartoffeln</li>
                        </ul>
                    </details>
                    <p>Energiewerte: 3347KJ / 800kcal</p>
                    <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
                </div>
                <div style="border: 1px solid black; margin: 15px; padding: 10px; width: 30%;">
                    <h3 style="font-weight: bold;">Bacon Burger Menü</h3>
                    <img src="Images/Burger_Menues.png" alt="Burger Menü 3" style="width: 100%;">
                    <p>Preis: 11.99€</p>
                    <details>
                        <summary>Beinhaltet</summary>
                        <ul>
                            <li>Bacon Burger</li>
                            <li>Pommes</li>
                            <li>Getränk</li>
                        </ul>
                    </details>
                    <details>
                        <summary>Zutaten</summary>
                        <ul>
                            <li>Brot</li>
                            <li>Beef Patty</li>
                            <li>Käse</li>
                            <li>Bacon</li>
                            <li>Tomaten</li>
                            <li>Zwiebeln</li>
                            <li>Salat</li>
                            <li>Kartoffeln</li>
                        </ul>
                    </details>
                    <p>Energiewerte: 3974KJ / 950kcal</p>
                    <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
                </div>
            </div>
        `,
        Hamburgers: `
            <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                <h3 style="font-weight: bold;">Hamburger</h3>
                <img src="Images/Burger_Single.png" alt="Burger Menü 1" style="width: 100%;">
                <p>Preis: 4.99€</p>
                <details>
                <summary>Zutaten</summary>
                <ul>
                    <li>Brot</li>
                    <li>Beef Patty</li>
                    <li>Tomaten</li>
                    <li>Zwiebeln</li>
                    <li>Salat</li>
                </ul>
                </details>
                <p>Energiewerte: 2301KJ / 550kcal</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                <h3 style="font-weight: bold;">Cheese Burger</h3>
                <img src="Images/Burger_Single.png" alt="Burger Menü 2" style="width: 100%;">
                <p>Preis: 5.99€</p>
                <details>
                <summary>Zutaten</summary>
                <ul>
                    <li>Brot</li>
                    <li>Beef Patty</li>
                    <li>Käse</li>
                    <li>Tomaten</li>
                    <li>Zwiebeln</li>
                    <li>Salat</li>
                </ul>
                </details>
                <p>Energiewerte: 2824KJ / 675kcal</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                <h3 style="font-weight: bold;">Bacon Burger</h3>
                <img src="Images/Burger_Single.png" alt="Burger Menü 3" style="width: 100%;">
                <p>Preis: 6.99€</p>
                <details>
                <summary>Zutaten</summary>
                <ul>
                    <li>Brot</li>
                    <li>Beef Patty</li>
                    <li>Käse</li>
                    <li>Bacon</li>
                    <li>Tomaten</li>
                    <li>Zwiebeln</li>
                    <li>Salat</li>
                </ul>
                </details>
                <p>Energiewerte: 3138KJ / 750kcal</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            </div>
        `,
        Pommes: `
            <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                    <h3 style="font-weight: bold;">Pommes</h3>
                    <img src="Images/Pommes.png" alt="Burger Menü 1" style="width: 100%;">
                    <p>Preis: 2.99€</p>
                    <details>
                    <summary>Zutaten</summary>
                    <ul>
                    <li>Kartoffeln</li>
                    </ul>
                    </details>
                    <p>Energiewerte: 920KJ / 220kcal</p>
                    <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
                </div>
            </div>
        `,
        Getränke: `
            <div style="display: flex; flex-wrap: wrap; justify-content: center;">
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                <h3 style="font-weight: bold;">Wasser Still 0.5L</h3>
                <img src="Images/Getränke/Wasser_Still.png" alt="Burger Menü 1" style="width: 100%;">
                <p>Preis: 1.49€</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                 <h3 style="font-weight: bold;">Wasser Medium 0.5L</h3>
                <img src="Images/Getränke/Wasser_Medium.png" alt="Burger Menü 2" style="width: 100%;">
                <p>Preis: 1.49€</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            <div style="border: 1px solid black; margin: 20px; padding: 10px; width: 30%;">
                <h3 style="font-weight: bold;">Wasser Sprudelig 0.5L</h3>
                <img src="Images/Getränke/Wasser_Sprudelig.png" alt="Burger Menü 3" style="width: 100%;">
                <p>Preis: 1.49€</p>
                <button class="btn btn-success" style="border-radius: 15px;">Zum Warenkorb hinzufügen</button>
            </div>
            </div>
        `,
        Shopping_Cart: `
            <div style="display: flex;">
                <div style="flex: 1; padding: 10px; background-color: rgb(245, 245, 245); border-radius: 15px; margin-right: 25px;">
                    <span style="font-size: 20px; font-weight: bold;">Checkout</span>
                </div>
                <div style="flex: 1; padding: 10px; background-color: rgb(245, 245, 245); border-radius: 15px;">
                    <span style="font-size: 20px; font-weight: bold;">Rechnungsadresse</span>
                    <div style="margin-bottom: 15px; margin-top: 15px;">
                        <span>Vorname</span>
                        <input type="text" class="form-control" maxlength="30">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <span>Nachname</span>
                        <input type="text" class="form-control" maxlength="30">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <span>Postleitzahl</span>
                        <input type="text" class="form-control" maxlength="5">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <span>Ort</span>
                        <input type="text" class="form-control" maxlength="40">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <span>Straße</span>
                        <input type="text" class="form-control" maxlength="40">
                    </div>
                    <div style="margin-bottom: 5px;">
                        <span>Hausnummer</span>
                        <input type="text" class="form-control" maxlength="3">
                    </div>
                </div>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 50px;">
                <button class="btn btn-success" style="border-radius: 15px; width: 750px;">Bestellung aufgeben</button>
            </div>
        `,
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
