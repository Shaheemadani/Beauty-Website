const subcategories = {
  face: ["foundation", "primer", "setting-powder", "makeup-remover", "blush"],
  lip: ["lipstick", "lip-liner", "lip-stain", "lip-balm", "lip-gloss"],
  eye: ["eye-shadow", "mascara", "eye-lashes", "eye-liner"],
  nail: ["nail-polish", "nail-remover"]
};

function showSubcategories(mainCategory) {
  const container = document.getElementById("subcategoryContainer");
  container.innerHTML = "";

  if (subcategories[mainCategory]) {
    subcategories[mainCategory].forEach(sub => {
      const btn = document.createElement("button");
      btn.innerText = sub.replace(/-/g, " ");
      btn.onclick = () => filterSubcategory(mainCategory, sub);
      container.appendChild(btn);
    });
  }

  filterCategory(mainCategory);
}

function filterCategory(category) {
  const products = document.querySelectorAll(".product-card");
  products.forEach(p => {
    if (category === "all" || p.classList.contains(category)) {
      p.style.display = "block";
    } else {
      p.style.display = "none";
    }
  });
}

function filterSubcategory(main, sub) {
  const products = document.querySelectorAll(".product-card");
  products.forEach(p => {
    if (p.classList.contains(main) && p.classList.contains(sub)) {
      p.style.display = "block";
    } else {
      p.style.display = "none";
    }
  });
}

// Show all products on load
window.onload = function () {
  showSubcategories('all');
};





/* add to cart code section*/
window.onload = function () {
  var addToCartButtons = document.querySelectorAll(".add-to-cart");
  var buyNowButtons = document.querySelectorAll(".buy-now");

  for (var i = 0; i < addToCartButtons.length; i++) {
    addToCartButtons[i].addEventListener("click", function () {
      var product = getProduct(this);
      addToCart(product);
      alert(product.name + " added to cart!");
    });
  }

  for (var i = 0; i < buyNowButtons.length; i++) {
    buyNowButtons[i].addEventListener("click", function () {
      var product = getProduct(this);
      addToCart(product);
      window.location.href = "cart.html#step2";
    });
  }
};

function getProduct(button) {
  var card = button.closest(".product-card");
  var name = card.querySelector("h4").innerText;
  var price = parseFloat(card.querySelector("p").innerText.replace(/[^\d.]/g, ""));
  var image = card.querySelector("img").src;
  return {
    name: name,
    price: price,
    image: image,
    qty: 1
  };
}

function addToCart(product) {
  var cart = JSON.parse(localStorage.getItem("cart")) || [];
  var exists = false;

  for (var i = 0; i < cart.length; i++) {
    if (cart[i].name === product.name) {
      cart[i].qty += 1;
      exists = true;
      break;
    }
  }

  if (!exists) {
    cart.push(product);
  }

  localStorage.setItem("cart", JSON.stringify(cart));
}