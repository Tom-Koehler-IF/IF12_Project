function addToCart(productKey) {
  ajax_fetch(
    '/ajax/cart.php',
    'POST',
    { 'Content-Type': 'application/x-www-form-urlencoded' },
    `product=${productKey}`
  ).then(() => {
    console.log('Product added to cart');
    const toastEl = document.getElementById('cartToast');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  })
  .catch(console.error);
}
