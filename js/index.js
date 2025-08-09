let slideIndex = 0;
let lastScrollTop = 0; // Track scroll position
const navbar = document.querySelector('.navbar'); // Target the navbar

showSlides();

function showSlides() {
  const slides = document.getElementsByClassName("slide");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) { slideIndex = 1 }
  slides[slideIndex - 1].style.display = "block";
  setTimeout(showSlides, 4000);
}

window.addEventListener("scroll", () => {
  let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

  if (currentScroll > lastScrollTop) {
    navbar.classList.add("hidden"); // Hide navbar when scrolling down
  } else {
    navbar.classList.remove("hidden"); // Show navbar when scrolling up
  }

  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Prevent negative
});