import './bootstrap';
import '../sass/app.scss'

// Show page content when DOM loaded
document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM fully loaded and parsed");
    document.body.style.display='block';
});



// SCROLL TO TOP BUTTON
const scrollToTopButton = document.getElementById("scrollToTopButton");
const btnVisibility = () => {
    if (window.scrollY > 400) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
};
document.addEventListener("scroll", () => {
    btnVisibility();
});
scrollToTopButton.addEventListener("click", () => {
  window.scrollTo({
      top: 0,
      behavior: "smooth"
  });
});

