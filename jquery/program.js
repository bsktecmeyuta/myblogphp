console.log('hello');
//jQueryで動作
$('header').fadeIn(500);
$('section').fadeIn(500);

$('#popup').fadeIn(1000);

$('#footer').fadeIn(500);

// document.getElementById('close').onclick=function(){
//   $('#popup').slideUp(500);
// }

$('#close').click(function(){
  // $('#popup').slideUp(500);
  $('#popup').css('display','none');
})