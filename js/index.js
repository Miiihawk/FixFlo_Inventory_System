var dropdownBtn = document.querySelector(".dropdown-btn");
var dropdownMenu = document.querySelector(".dropdown-menu");

dropdownBtn.addEventListener("click", toggleMenu)


function toggleMenu() {
  dropdownMenu.classList.toggle('open')
}
