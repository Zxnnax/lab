document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("loginToggle");
    const dropdown = document.getElementById("loginDropdown");
    const wrapper = document.getElementById("loginWrapper");
  
    if (toggle && dropdown && wrapper) {
      toggle.addEventListener("click", function (e) {
        e.preventDefault();
        dropdown.classList.toggle("show");
      });
  
      document.addEventListener("click", function (e) {
        if (!wrapper.contains(e.target)) {
          dropdown.classList.remove("show");
        }
      });
    }
  });
  