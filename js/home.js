// script.js
document.addEventListener("DOMContentLoaded", function () {
    const aboutContactSection = document.getElementById("about-contact");
    const navLinks = document.querySelectorAll("nav a[href='#about-contact']");
  
    navLinks.forEach(link => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        aboutContactSection.scrollIntoView({ behavior: "smooth" });
      });
    });
  });
  