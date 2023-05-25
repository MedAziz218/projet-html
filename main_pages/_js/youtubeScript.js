var youTubePlayer;
const defaultVideoID = "";
// API key
//AIzaSyD6MsAdY9QLvBQzSX_o-b6RsJt_kRwdPfQ
function onYouTubeIframeAPIReady() {
  'use strict';

  var inputVideoId = document.getElementById('player');
  var videoGroup = document.getElementById('video-group');
  var videoId = defaultVideoID;//inputVideoId.value;
  var suggestedQuality = 'tiny';
  var height = 400;
  var width = parseInt(videoGroup.offsetWidth) || 0

  function onError(event) {
      youTubePlayer.personalPlayer.errors.push(event.data);
  }


  function onReady(event) {
      var player = event.target;

      
      // player.pauseVideo();
      
      setTimeout(myOnReady,500);
      setInterval(youTubePlayerDisplayInfos, 1000);
      setInterval(myvoidLoop, 1000);

  }


  function onStateChange(event) {
    var player = event.target;
    if (youTubePlayerActive()){
      myOnStateChange(player.getPlayerState());

    }
  }


  youTubePlayer = new YT.Player('player',
                                {videoId: videoId,
                                 height: height,
                                 width: width,
                                 playerVars: {'autohide': 0,
                                              'cc_load_policy': 0,
                                              'controls': 2,
                                              'disablekb': 1,
                                              'iv_load_policy': 3,
                                              'modestbranding': 1,
                                              'rel': 0,
                                              'showinfo': 0,
                                              'start': 3
                                             },
                                 events: {'onError': onError,
                                          'onReady': onReady,
                                          'onStateChange': onStateChange
                                         }
                                });

  // Add private data to the YouTube object
  youTubePlayer.personalPlayer = {'currentTimeSliding': false,
                                  'errors': []};
}


/**
 * Stop.
 */
function youTubePlayerStop() {
  'use strict';

  if (youTubePlayerActive()) {
      youTubePlayer.stopVideo();
      youTubePlayer.clearVideo();
  }
}
/**
 * Pause.
 */
function youTubePlayerPause() {
  'use strict';

  if (youTubePlayerActive()) {
      youTubePlayer.pauseVideo();
  }
}

/**
* Play.
*/
function youTubePlayerPlay() {
  'use strict';

  if (youTubePlayerActive()) {
      youTubePlayer.playVideo();
  }
}
/**
* getState.  var STATES = {'-1': 'unstarted',   // YT.PlayerState.
                  '0': 'ended',        // YT.PlayerState.ENDED
                  '1': 'playing',      // YT.PlayerState.PLAYING
                  '2': 'paused',       // YT.PlayerState.PAUSED
                  '3': 'buffering',    // YT.PlayerState.BUFFERING
                  '5': 'video cued'};  // YT.PlayerState.CUED

*/
function youTubePlayerGetState() {
  'use strict';

  if (youTubePlayerActive()) {
    return youTubePlayer.getPlayerState()
  }
  return null;
}

function youTubePlayerCurrentTimeSlide() {
  'use strict';

  youTubePlayer.personalPlayer.currentTimeSliding = true;
}
function youTubePlayerCurrentTimeChange(currentTime) {
  'use strict';

  youTubePlayer.personalPlayer.currentTimeSliding = false;
  if (youTubePlayerActive()) {
      youTubePlayer.seekTo(currentTime*youTubePlayer.getDuration()/100, true);
  }
}
function youTubePlayerCurrentTimeChangeSeconds(currentTime) {
  'use strict';

  youTubePlayer.personalPlayer.currentTimeSliding = false;
  if (youTubePlayerActive()) {
      youTubePlayer.seekTo(currentTime, true);
  }
}
function youTubePlayerActive() {
  'use strict';
  return youTubePlayer && youTubePlayer.hasOwnProperty('getPlayerState');
}
function youTubePlayerChangeVideoId(videoId) {
  'use strict';

  youTubePlayer.cueVideoById({suggestedQuality: 'tiny',
                              videoId: videoId
                             });
  
  // youTubePlayer.pauseVideo();
  // youTubePlayer.stopVideo();
}


// my own -------------------------
function youTubePlayerGetTime(){
  return "hola";
}
var currentTime = 0;
function youTubePlayerDisplayInfos(){
  currentTime = youTubePlayer.getCurrentTime();
  var current = currentTime;
  var duration = youTubePlayer.getDuration();
  var currentPercent = (current && duration
                              ? current*100/duration
                              : 0);
  
  if (!youTubePlayer.personalPlayer.currentTimeSliding) {
    document.getElementById('YouTube-player-progress').value = currentPercent;
    var volume = youTubePlayer.getVolume();
  }
}
function youtube_parser(url){
  var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
  var match = url.match(regExp);
  return (match&&match[7].length==11)? match[7] : false;
}

function youtube_title(videoId) {
  const apiKey ="AIzaSyD6MsAdY9QLvBQzSX_o-b6RsJt_kRwdPfQ"; // replace with your own YouTube Data API key
  
  return fetch(`https://www.googleapis.com/youtube/v3/videos?id=${videoId}&key=${apiKey}&part=snippet`)
    .then(response => response.json())
    .then(data => data.items[0].snippet);
}
function youtube_thumbnail_url(vid_id){
  
  return "http://img.youtube.com/vi/<youtube-video-id>/default.jpg".replace("<youtube-video-id>",vid_id);
}

function YouTubeGetID(url_orig) {
  var ID = "";
  var url = url_orig
    .replace(/(>|<)/gi, "")
    .split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
  console.log(url);
  console.log("----------------------------------");
  if (url[2] !== undefined) {
    ID = url[2].split(/[^0-9a-z_\-]/i);
    ID = ID[0];
  } else {
    ID = url_orig;
  }
  return ID;
}

/**
 * Main
 */
(function () {
  'use strict';

  function init() {
      // Load YouTube library
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      
      
      // Set timer to display infos
      // setInterval(youTubePlayerDisplayInfos, 1000);
  }


  if (window.addEventListener) {
      window.addEventListener('load', init);
  } else if (window.attachEvent) {
      window.attachEvent('onload', init);
  }
}());