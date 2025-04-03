function switchClasses(activeContent, inactiveContent, doNotReload) {
    let orderButton = document.getElementById("orderButton");
    let contestButton = document.getElementById("contestButton");

    if (activeContent === 'order') {
        orderButton.className = "btn btn-success";
        contestButton.className = "btn btn-secondary";

        if(!doNotReload) {
            loadProductCategory(INITIAL_CATEGORY);
        }
    } else if (activeContent === 'Funny_Dinner_Contest' || activeContent === 'Funny_Dinner_Contest_Rating') {
        orderButton.className = "btn btn-secondary";
        contestButton.className = "btn btn-success";

        // Reset the color of all buttons to default
        const buttons = document.querySelectorAll('.category-button');
        buttons.forEach(btn => btn.style.setProperty('color', '#000', 'important'));

        loadDinnerContest(false);
    }
}

function highlightCategory(button) {
  // Reset all buttons to default color
  const buttons = document.querySelectorAll('.category-button');
  buttons.forEach(btn => btn.style.setProperty('color', '#000', 'important'));

  // Set the clicked button color to #28a745
  button.style.setProperty('color', '#28a745', 'important');
}

function redirectToLogin() {
  window.location.href = "Login.php";
}

function loadCheckout() {
    document.getElementById('main-content').innerHTML = 'TODO';

    ajax_fetch(`/ajax/checkout.php`, 'GET')
        .then(r => r.text())
        .then(loadInnerContent)
        .catch(alert);
}

function loadProductCategory(category) {
    document.getElementById('main-content').innerHTML = 'TODO';

    ajax_fetch(`/ajax/product.php?category=${category}`, 'GET')
        .then(r => r.text())
        .then(loadInnerContent)
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

  // Remove previously added <link> tags
  const head = document.head;
  Array.from(head.querySelectorAll("link[data-dynamic='true']")).forEach(link => link.remove());

  // Process <script> tags
  Array.from(elm.querySelectorAll("script"))
    .forEach(oldScriptEl => {
      const newScriptEl = document.createElement("script");

      Array.from(oldScriptEl.attributes).forEach(attr => {
        newScriptEl.setAttribute(attr.name, attr.value);
      });

      const scriptText = document.createTextNode(oldScriptEl.innerHTML);
      newScriptEl.appendChild(scriptText);

      oldScriptEl.parentNode.replaceChild(newScriptEl, oldScriptEl);
    });

  // Process <link> tags
  Array.from(elm.querySelectorAll("link")).forEach(linkEl => {
    const newLinkEl = document.createElement("link");

    Array.from(linkEl.attributes).forEach(attr => {
      newLinkEl.setAttribute(attr.name, attr.value);
    });

    newLinkEl.setAttribute("data-dynamic", "true"); // Mark as dynamically added
    head.appendChild(newLinkEl);

    linkEl.parentNode.removeChild(linkEl); // Remove from the original location
  });
}

// Initially load the first product category
switchClasses('order', 'Funny_Dinner_Contest');