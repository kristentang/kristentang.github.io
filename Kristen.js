function resize(){
    if ($(window).width() < 1000) {
      window.alert("sometext");
      $(".pic img").attr('width', window.innerWidth/4);
  }
}
resize();
$(window).on('resize', resize);
