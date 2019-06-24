var host			= '192.99.62.212',
    port			= '9408',
    yenileme	= 1000,
    radyo_url	= 'http://'+host+':'+port+'/;stream.mp3';

$(".liste").click(function(){
  $("#gecmis").slideToggle();
});

var player = new MediaElementPlayer('audio');
interval = setInterval(function(){
  $.SHOUTcast({
    host : host,
    port : port
  }).stats(function(){
    if(this.onAir()){
      $("#player, #gecmis").removeClass("offline").addClass("online");
      radyoismi		= this.get("servertitle");
      calansarki	= this.get("songtitle");
      $("#mesaj marquee").text('Şu anda bu yayını ' + this.get('currentlisteners') + ' kişi dinliyor!');
      $("#icerik p").html();
      if(radyoismi.length >= 50){
        radyoismi = radyoismi.substr(0,50);
      }
      if(calansarki.length >= 50){
        calansarki = calansarki.substr(0,50);
      }
      $(".radyo strong").text(radyoismi);
      $(".sarki span").text(calansarki);
      $.getJSON('https://api.spotify.com/v1/search?q='+calansarki+'&type=track', function(response){
        $("#icerik").css('background-image', 'url(' + response.tracks.items[0].album.images[0].url + ')');
        $("#kapak img").attr('src', response.tracks.items[0].album.images[2].url);
      })
    }else{
      // Yayın kapalı
      $("#player, #gecmis").removeClass("online").addClass("offline");
      $(".radyo strong").text("Gazi FM");
      $(".sarki span").text("Yayın şu anda kapalı.");
      $("#kapak img").attr("src", logo);
    }
  }).played(function(tracks){
    $("#gecmis").html("");
    $.each(tracks, function(k,track){
      $("#gecmis").append('<li><i class="fa fa-music"></i> ' + track.title + '</li>');
    });
  });
}, 1000);

$("#kontrol").click(function(){
  icon = $(this).find("i");
  if(icon.attr('class') == 'fa fa-play play'){
    player.play();
    icon.attr('class', 'glyphicon glyphicon-pause play');
  }else{
    player.pause();
    icon.attr('class', 'fa fa-play play');
  }
});

$(".yenile").click(function(){
  player.setSrc(radyo_url);
});

$(".sessiz").click(function(){
  icon = $(this).find('i');
  if(icon.attr('class') == 'fa fa-volume-up'){
    icon.attr('class', 'fa fa-volume-off');
    player.setMuted(true);
  }else{
    icon.attr('class', 'fa fa-volume-up');
    player.setMuted(false);
  }
});

$('[data-toggle=tooltip]').tooltip();
