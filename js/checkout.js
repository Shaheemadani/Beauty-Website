document.addEventListener("DOMContentLoaded", () => {
  const toPaymentBtn = document.getElementById("to-payment");
  const backToCustomerBtn = document.getElementById("back-to-customer");
  const customerStep = document.getElementById("customer-step");
  const paymentStep = document.getElementById("payment-step");
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Form elements
  const fullName = document.getElementById("fullName");
  const city = document.getElementById("city");
  const district = document.getElementById("district");
  const street = document.getElementById("street");
  const phone = document.getElementById("phone");
  const email = document.getElementById("email");

  // Hidden form fields
  const hiddenFullName = document.getElementById("hiddenFullName");
  const hiddenCity = document.getElementById("hiddenCity");
  const hiddenDistrict = document.getElementById("hiddenDistrict");
  const hiddenStreet = document.getElementById("hiddenStreet");
  const hiddenPhone = document.getElementById("hiddenPhone");
  const hiddenEmail = document.getElementById("hiddenEmail");
  const hiddenPayment = document.getElementById("hiddenPayment");
  const totalAmountInput = document.getElementById("totalAmountInput");

  // Payment elements
  const paymentRadios = document.querySelectorAll("input[name='payment']");
  const cardDetailsSection = document.getElementById("card-details");

  // Show/hide card details
  paymentRadios.forEach(radio => {
    radio.addEventListener("change", () => {
      cardDetailsSection.style.display = radio.value === "Card" ? "block" : "none";
    });
  });

  // Next button click handler
  toPaymentBtn.addEventListener("click", () => {
    if (!fullName.value || !city.value || !district.value ||
        !street.value || !phone.value || !email.value) {
      alert("Please fill in all customer details.");
      return;
    }

    // Fill hidden fields
    hiddenFullName.value = fullName.value;
    hiddenCity.value = city.value;
    hiddenDistrict.value = district.value;
    hiddenStreet.value = street.value;
    hiddenPhone.value = phone.value;
    hiddenEmail.value = email.value;

    // Calculate total
    let total = 0;
    cart.forEach(item => {
      total += parseFloat(item.price) * parseInt(item.qty);
    });
    totalAmountInput.value = total.toFixed(2);

    // Move to payment step
    customerStep.classList.remove("active");
    paymentStep.classList.add("active");
  });

  // Back button click handler
  backToCustomerBtn.addEventListener("click", () => {
    paymentStep.classList.remove("active");
    customerStep.classList.add("active");
  });

  // Form submit handler
  const paymentForm = document.getElementById("payment-form");
  paymentForm.addEventListener("submit", () => {
    const selectedPayment = document.querySelector("input[name='payment']:checked").value;
    hiddenPayment.value = selectedPayment;
  });
});