var player,
    time_update_interval = 0;

var youtubeVideoId = $(".videoSection").attr('data-vid');
var muteVideo = $(".videoSection").attr('data-mute');
var autoPlayVideo = $(".videoSection").attr('data-autoplay');

if( youtubeVideoId ) {

  function onYouTubeIframeAPIReady() {
      player = new YT.Player('video-placeholder', {
          width: 640,
          height: 390,
          videoId: youtubeVideoId,
          playerVars: {
              color: 'white',
              playlist: ''
          },
          events: {
              onReady: initialize
          }
      });
  }

  function initialize(){

      // Update the controls on load
      updateTimerDisplay();
      updateProgressBar();

      // Clear any old interval.
      clearInterval(time_update_interval);

      // Start interval to update elapsed time display and
      // the elapsed part of the progress bar every second.
      time_update_interval = setInterval(function () {
          updateTimerDisplay();
          updateProgressBar();
      }, 1000);


      $('#volume-input').val(Math.round(player.getVolume()));

      if(muteVideo) {
        player.mute();
      } else {
        player.unMute();
      }
  }


  // This function is called by initialize()
  function updateTimerDisplay(){
      // Update current time text display.
      $('#current-time').text(formatTime( player.getCurrentTime() ));
      $('#duration').text(formatTime( player.getDuration() ));
  }


  // This function is called by initialize()
  function updateProgressBar(){
      // Update the value of our progress bar accordingly.
      $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
  }


  // Progress bar

  $('#progress-bar').on('mouseup touchend', function (e) {

      // Calculate the new time for the video.
      // new time in seconds = total duration in seconds * ( value of range input / 100 )
      var newTime = player.getDuration() * (e.target.value / 100);

      // Skip video to new time.
      player.seekTo(newTime);

  });


  // Playback

  $('#play').on('click', function (e) {
      e.preventDefault();
      player.playVideo();
  });


  $('#pause').on('click', function (e) {
      e.preventDefault();
      player.pauseVideo();
  });


  // Sound volume


  $('#mute-toggle').on('click', function(e) {
      e.preventDefault();
      var mute_toggle = $(this);

      if(player.isMuted()){
          player.unMute();
          mute_toggle.text('volume_up');
      }
      else{
          player.mute();
          mute_toggle.text('volume_off');
      }
  });

  $('#volume-input').on('change', function (e) {
      player.setVolume($(this).val());
  });


  // Other options


  $('#speed').on('change', function () {
      player.setPlaybackRate($(this).val());
  });

  $('#quality').on('change', function () {
      player.setPlaybackQuality($(this).val());
  });


  // Playlist

  $('#next').on('click', function (e) {
      player.nextVideo()
  });

  $('#prev').on('click', function (e) {
      player.previousVideo()
  });


  // Load video

  $('.thumbnail').on('click', function () {

      var url = $(this).attr('data-video-id');

      player.cueVideoById(url);

  });


  // Helper Functions

  function formatTime(time){
      time = Math.round(time);

      var minutes = Math.floor(time / 60),
          seconds = time - minutes * 60;

      seconds = seconds < 10 ? '0' + seconds : seconds;

      return minutes + ":" + seconds;
  }

  // API event: when the player is ready, call the function in the queue
  function onPlayerReady() {
    if (queue.content) queue.pop();
  }

  // Helper function to check if the player is ready
  function isPlayerReady(player) {
    return player && typeof player.playVideo === 'function';
  }

  function playVideo(player) {
    isPlayerReady(player) ? player.playVideo() : queue.push(function() {
                                                 player.playVideo();
                                               });
  }

  $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
  };
  var isPlaying = false;
  $(window).on('resize scroll', function() {
      var iframeID = $("#video-placeholder");
      if ( $('.videoSection').isInViewport() ) {
          if(autoPlayVideo) {
            //$('#mute-toggle').trigger("click");
            $('#play').trigger("click");
            //player.playVideo();
          }
      } else {
          if(autoPlayVideo) {
            $('#pause').trigger("click");
            //player.pauseVideo();
          }
      }
  });

}


