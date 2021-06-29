const menuBtn = document.querySelector('.menu-btn');
let menuOpen = false;
menuBtn.addEventListener('click', () => {
  if (!menuOpen) {
    menuBtn.classList.add('open');
    menuOpen = true;
    console.log('open');
  } else {
    menuBtn.classList.remove('open');
    menuOpen = false;
    console.log('close');
  }
});
$('.carousel').carousel();
