<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'>
<link rel='stylesheet' href='http://mediaelementjs.com/js/mejs-2.16.4/mediaelementplayer.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="css/style.css">
<script  src="js/script.js"></script>



<div id="icerik">
</div>
<footer id="player">
  <audio src="http://online.radiorecord.ru:8102/househits_320" type="audio/mp3" controls="controls" class="player" autoplay></audio>
  <div class="container">
    <ul id="gecmis"></ul>
    <div id="bilgiler">
      <div id="kapak">
        <img src="http://www.flaticon.com/premium-icon/icons/svg/193/193154.svg" alt="" />
      </div>
      <div class="radyo"><strong></strong></div>
      <br>
      <div class="sarki"><strong>Now playing: </strong><span></span></div>
      <div class="liste" data-toggle="tooltip" data-placement="top" title="Önceki Şarkılar"><i class="fa fa-bars"></i></div>
      <div class="istek" data-toggle="modal" data-target="#myModal"><i class="fa fa-envelope" data-toggle="tooltip" data-placement="top" title="İstek Gönder" ></i></div>
    </div>
    <div id="kontrol" data-toggle="tooltip" data-placement="top" title="Oynat / Durdur">
      <i class="fa fa-play play"></i>
    </div>
    <div id="sag">
      <div class="yenile" data-toggle="tooltip" data-placement="top" title="Yenile"><i class="fa fa-refresh"></i></div>
      <div class="sessiz" data-toggle="tooltip" data-placement="top" title="Sessiz"><i class="fa fa-volume-up"></i></div>
      <div id="mesaj">
      </div>
      <div id="sosyal">
        <li><a href="" target="_blank"><i class="fa fa-facebook"></i></a></li>
        <li><a href="" target="_blank"><i class="fa fa-twitter"></i></a></li>
        <li><a href="" target="_blank"><i class="fa fa-apple"></i></a></li>
        <li><a href="" target="_blank"><i class="fa fa-android"></i></a></li>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">İstek Hattı</h4>
        </div>
        <div class="modal-body">
           <p class="alert alert-danger">Bu radyo istek kabul etmiyor :/</p>
        </div>
      </div>
    </div>
  </div>
</footer>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
<script src='https://designshack.net/tutorialexamples/html5-audio-player/js/mediaelement-and-player.min.js'></script>
<script src='https://www.soundreef.com/js/jquery-shoutcast-master/jquery.shoutcast.min.js'></script>
<script  src="js/script.js"></script>

