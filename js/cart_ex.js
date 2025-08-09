let cart = JSON.parse(localStorage.getItem("cart")) || [];

function renderCart() {
  const cartItemsContainer = document.getElementById("cart-items");
  const cartSubtotal = document.getElementById("cart-subtotal");
  const cartShipping = document.getElementById("cart-shipping");
  const cartTotal = document.getElementById("cart-total");
  cartItemsContainer.innerHTML = "";
  let subtotal = 0;

  cart.forEach((item, i) => {
    const price = parseFloat(item.price) || 0;
    const qty = parseInt(item.qty) || 1;
    const itemTotal = price * qty;
    subtotal += itemTotal;

    const itemDiv = document.createElement("div");
    itemDiv.className = "cart-item";
    itemDiv.innerHTML = `
      <img src="${item.image}" alt="${item.name}" width="80">
      <div class="item-details">
        <h3>${item.name}</h3>
        <p>Price: Rs. ${price}</p>
        <div class="quantity-controls">
          <button onclick="decreaseQuantity(${i})">-</button>
          <span>${qty}</span>
          <button onclick="increaseQuantity(${i})">+</button>
        </div>
        <p>Total: Rs. ${itemTotal.toFixed(2)}</p>
      </div>
      <button class="remove-btn" onclick="removeItem(${i})"><i class="fas fa-trash-alt"></i></button>
    `;
    cartItemsContainer.appendChild(itemDiv);
  });

  cartSubtotal.textContent = subtotal.toFixed(2);
  cartShipping.textContent = "200.00";
  cartTotal.textContent = (subtotal + 200).toFixed(2);
  localStorage.setItem("cart", JSON.stringify(cart));
}

function increaseQuantity(index) {
  cart[index].qty++;
  renderCart();
}

function decreaseQuantity(index) {
  if (cart[index].qty > 1) {
    cart[index].qty--;
  } else {
    cart.splice(index, 1);
  }
  renderCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  renderCart();
}

const steps = document.querySelectorAll('.step');
function showStep(stepName) {
  steps.forEach(step => step.classList.remove('active'));
  document.querySelector('.step-' + stepName).classList.add('active');
}

document.getElementById('next-to-customer').addEventListener('click', function () {
  if (cart.length === 0) {
    alert("Your cart is empty.");
    return;
  }
  showStep('customer');
});

document.getElementById('customer-form').addEventListener('submit', function (e) {
  e.preventDefault();
  showStep('payment');
});

document.querySelectorAll('.back-btn').forEach(button => {
  button.addEventListener('click', function () {
    const step = this.getAttribute('data-step');
    showStep(step);
  });
});

// Show/hide card details
document.querySelectorAll('input[name="payment"]').forEach(radio => {
  radio.addEventListener('change', () => {
    const cardSection = document.getElementById('card-details');
    const isCard = document.getElementById('card').checked;
    cardSection.style.display = isCard ? 'block' : 'none';
  });
});

document.getElementById('payment-form').addEventListener('submit', function (e) {
  e.preventDefault();
  window.location.href = "thank.html";
});



// ✅ Step 3 Submit → thank.html
const paymentForm = document.getElementById("payment-form");
paymentForm.addEventListener('submit', function (e) {
  e.preventDefault();

  // Clear the cart from localStorage
  localStorage.removeItem("cart");

  // Redirect to Thank You page
  window.location.href = "thank.html";
});

// ✅ Check if cart is empty on load
window.addEventListener("load", function () {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  if (cart.length === 0) {
    document.getElementById("cart-items").innerHTML = "<p>Your cart is empty.</p>";
    document.getElementById("cart-summary").style.display = "none";
    document.getElementById("step2").style.display = "none";
    document.getElementById("step3").style.display = "none";
  } else {
    renderCart();
  }
});
