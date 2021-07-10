const menuBtn = document.querySelector('.menu-btn');

$(window).scroll(function () {
  $('.arrow').css('display', 'inline');
});

let menuOpen = false;
menuBtn.addEventListener('click', () => {
  if (!menuOpen) {
    menuBtn.classList.add('open');
    menuOpen = true;
    // console.log('open');
  } else {
    menuBtn.classList.remove('open');
    menuOpen = false;
    // console.log('close');
  }
});
