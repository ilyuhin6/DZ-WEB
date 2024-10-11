const navbar = document.querySelector('.header-nav-bar');
const lightModeOn = (event) => {
  navbar.classList.add('header-nav-bar-scrol');
};

const lightModeOff = (event) => {
  navbar.classList.remove('header-nav-bar-scrol');
}
window.addEventListener('scroll', () => {
  this.scrollY > 3 ?  lightModeOn() : lightModeOff();
});



