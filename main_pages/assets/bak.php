
<!DOCTYPE html>
<?php
session_start();

if(empty($_SESSION["id"])){
  header("Location: ../index.html"); 
}
if (empty($_SESSION["remember_me"])){
  session_destroy();
}
?>
<html>
  <head>
    <link rel="stylesheet" href="_css/styles.css" />
    <link rel="stylesheet" href="_css/playlist.css" />
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="_js/youtubeScript.js"></script>
    <script src="_js/index.js"></script>
    <!-- <script type="text/javascript" src="https://tiiny.host/ad-script.js"></script><script defer data-domain="projethtml.tiiny.site" src="https://analytics.tiiny.site/js/plausible.js"></script></head> -->
  <body>
    <section>
    <div id="data">
      
    </div>
      <div class="container">
        <header class="header">
          <h1 id="title" class="text-center">Youtube Playlist Creator</h1>
          <p id="description" class="description text-center">
            Create Edit and Share your favourite songs and
          </p>
        </header>
        <main class="main">
          <div id="video-group" class="form-group" style="width: 100%;display: none;">
              <div id="player"></div>
          </div>
          <div id="no-media-info" class="form-group" style="width: 100%;">
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

          <div class="form-group">
            <label id="URL-label" for="URL">URL</label>
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
              <button id="add-btn" class="btn add-btn">add</button>
            </div>
          </div>

          <div id="playlist" class="form-group task-list"> </div>
          
          <div class="form-group clear-btn-div">
            <button id="clear-btn" class="btn">Clear list</button>
          </div>
        
          <hr/>         
        </main>
      </div>
      
    </section>
  </body>
</html>
