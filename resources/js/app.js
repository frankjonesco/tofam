import './bootstrap';
import '../sass/app.scss'

// Show page content when DOM loaded
document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM fully loaded and parsed");
    document.body.style.display='block';
  });