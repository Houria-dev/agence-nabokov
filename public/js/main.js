//Menu Hamburger
const menuBtn = document.querySelector(".menu-btn");
let menuOpen = false;
var menu = document.getElementById('menu');
menuBtn.addEventListener('click', () => {
    if(!menuOpen) {
        menuBtn.classList.add('open');
        menu.classList.add('d-flex');
        menuOpen = true;
    } else {
        menuBtn.classList.remove('open');
        menu.classList.remove('d-flex');
        menuOpen = false;
    }
});