// $(".openbtn4").click(function () {
//   $(this).toggleClass('active');
// });

let btn = document.getElementsByClassName('.openbtn4');
btn.addEventListener('click', function() {
  btn.classList.add('active');
}, false);