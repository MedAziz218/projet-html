
<!DOCTYPE html>
<?php
session_start();

if(empty($_SESSION["id"])){
  header("Location: ../index.html"); 
}
if (empty($_SESSION["remember_me"])){
  session_destroy();
}
if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: ../index.html"); 
}
if (isset($_GET['changeRoom'])) {
  unset($_GET['changeRoom']);
  unset($_SESSION["room"]);
  header("Location: createOrjoin.html"); 
}
if (isset($_GET["room"])){
  $_SESSION["room"] = $_GET["room"];
}
if (isset($_SESSION["room"])){
  $room=$_SESSION["room"];
  echo "<script>var ROOM_NAME='$room'; console.log(ROOM_NAME); </script>";

}
else {
  header("Location: createOrjoin.php"); 
}
?>
<html>
  <head>
    <title>main Page </title>
    <link rel="stylesheet" href="_css/playlist.css" />
    <link rel="stylesheet" href="_css/nav.css" />
    
    <link rel="stylesheet" href="_css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="_js/youtubeScript.js"></script>
    <script src="_js/index.js"></script>
    <script src="_js/syncronization_code.js"></script>
    <!-- <script type="text/javascript" src="https://tiiny.host/ad-script.js"></script><script defer data-domain="projethtml.tiiny.site" src="https://analytics.tiiny.site/js/plausible.js"></script></head> -->
    <head>
  <body>
    
  <section class="header">
    <nav>
      <a href="#" class="logoBig">WATCHSYNCED</a>
      <a href="#" class="logoSmall">WS</a>

      <div id="URL-group" >
              <input
                id="URL-input"
                type="text"
                name="URL"
                id="URL"
                class="form-control"
                placeholder="Enter your URL"
                required
              />
        </div>
      <div class="nav-links">
        <ul>

          <li><a href="#" id="add-btn"><i class="fa fa-plus"></i></a></li>
          <li><a href="index.php?changeRoom=true" id="settings-btn"><i class="fa fa-rotate-left"></i></a></li>
          <li><a href="index.php?logout=true" id="logout-btn"><i class="fa fa-sign-out"></i></a></li>
        </ul>
      </div>
    </nav>
  </section>


      <section class="container">
        <main class="main">
          <div id="video-group" class="form-group" style="width: 100%;display: none;">
              <div id="player"></div>
          </div>
          <div id="no-media-info" class="form-group" style="width: 100%;color:white;">
            <span>No Video</span>
          </div>
          
          <div class="form-group controls">
              <button class="control-btn previous"> 
                <i class="fa fa-step-backward"></i>
              </button>
              <button class="control-btn pause-play"> 
                <i class="fa fa-pause"></i>
              </button>
              <button class="control-btn next"> 
                <i class="fa fa-step-forward"></i>
              </button>
              <input id="YouTube-player-progress" type="range" value="0" min="0" max="100" onchange="youTubePlayerCurrentTimeChange(this.value);" oninput="youTubePlayerCurrentTimeSlide();">
              
            </div>
          <div id="playlist" class="form-group task-list" style="font-size:0.5rem"> </div>
          <div class="clear-btn-div">
              <button id="clear-btn" class="btn">Clear list</button>
              <button class="btn" onclick="test()">test</button>
              <button class="btn" onclick="test_up()">test</button>
              
          </div>  
        </main>
        <div style="max-width:500px;font-size:0.5rem">
      </section>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script>
    function test(){
    // console.log(ROOM_NAME);
    $.ajax({
     url: `getValueFromDB.php`,
     method: 'GET',
     data: {
      room: ROOM_NAME},
     dataType: 'text',
      async: true,
      success: function(result){
        //  console.log(result);
         syncWithDB(result);
    }});
    }

    function test_up(){
    // console.log(ROOM_NAME);
    $.ajax({
     url: `uploadValuetoDB.php`,
     method: 'GET',
     data: {
      room: ROOM_NAME,
      sql: sendToDB(ROOM_NAME),
    },
     dataType: 'text',
      async: true,
      success: function(result){
        console.log(result);
    }});


    }
  </script>

</html>
