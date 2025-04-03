function addToCart(productKey, productName) {
  ajax_fetch(
      '/ajax/cart.php',
      'POST',
      { 'Content-Type': 'application/x-www-form-urlencoded' },
      `product=${productKey}`
  ).then(() => {
      console.log('Product added to cart');
      console.log('Product name:', productName);

      // Neuen Toast für jedes Produkt erstellen
      const toastContainer = document.getElementById('toastContainer');
      const newToast = document.createElement('div');
      newToast.className = 'toast show';
      newToast.role = 'alert';
      newToast.ariaLive = 'assertive';
      newToast.ariaAtomic = 'true';

      newToast.innerHTML = `
          <div class="toast-header">
              <img src="images/Toast/Product_Added_IMG.jpg" class="rounded me-2" alt="Kreuz mit Plus" style="width: 20px; height:20px;">
              <strong class="me-auto">${productName}</strong>
              <small>Jetzt</small>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
              Erfolgreich in den Warenkorb gelegt!
          </div>
      `;

      toastContainer.appendChild(newToast);

      // Bootstrap-Toast initialisieren und anzeigen
      const toast = new bootstrap.Toast(newToast);
      toast.show();

      // Automatisch nach 5 Sekunden entfernen
      setTimeout(() => {
          newToast.remove();
      }, 5000);
  })
  .catch(console.error);
}
