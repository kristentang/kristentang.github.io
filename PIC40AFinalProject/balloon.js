let play = false;
function color(){
  $('#span_one').html(''); // set color of greeting box
  $('#span_two').html(''); // set color of greeting box
  $('#span_three').html("");
  let color = $('input[name=color]:checked').val();
  $('.circle').css('backgroundColor', color); // set color of greeting box
  $(".circle").css({width: "50px"});
  $(".circle").css({height: "50px"});
  $(".circle").css({marginTop: "-25px"});
  $(".circle").css({marginLeft: "-25px"});
  play = true;
}

function play_game(){
  if (play === true) {
    let random = Math.random()*100;
    let width  = $(".circle").width();
    let height = $(".circle").height();
    let marginTop = $(".circle").css('marginTop');
    let marginLeft = $(".circle").css('marginTop');
    marginTop = parseFloat(marginTop);
    marginLeft = parseFloat(marginLeft);
    if  (width + random <= 300) {
      $(".circle").css({width: width + random + "px"});
      $(".circle").css({height: height + random + "px"});
      $(".circle").css({marginTop: marginTop -(random/2) + "px"});
      $(".circle").css({marginLeft: marginLeft -(random/2) + "px"});

    } else {
      $('.circle').css('backgroundColor', "white"); // set color of greeting box
      $('#span_one').html('BALLOON POPPED'); // set color of greeting box
      $('#span_two').html('SCORE: 0'); // set color of greeting box
      $('#span_three').html("Click LET'S PLAY to play again");
      play = false;
    }
  }
}

function stop() {
  let marginTop = $(".circle").css('marginTop');
  marginTop = parseFloat(marginTop);
  let score = 300.0 - marginTop;
  score = score.toFixed(4);
  $('#span_one').html('GAME OVER'); // set color of greeting box
  $('#span_two').html('SCORE: ' + score); // set color of greeting box
  $('#span_three').html("Click LET'S PLAY to play again");
  play = false;

}

function redirect($username) {
  window.location.href="http://www.pic.ucla.edu/~kristentang/Final_Project/leaderboard.php?username="+$username;
}
