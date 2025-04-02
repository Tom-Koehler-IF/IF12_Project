function addToCart(productKey) {
    ajax_fetch(
      '/ajax/cart.php',
      'POST',
      { 'Content-Type': 'application/x-www-form-urlencoded' },
      `product=${productKey}`
    ).then(() => console.log('Added to cart'))
     .catch(console.error);
  }
  