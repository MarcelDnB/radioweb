new Vue({
  el: '#app',
  data: {
    streamUrl: 'https://air.radiorecord.ru:805/househits_320',
    volume: 0.75,
    canPlay: false,
    playing: false,
    lastPlayed: null,
    ctx: null,
    audio: null,
    source: null,
    metadata: null,
    metaInterval: null,
    reloadTimeout: null,
    noSupportedClass: 'no-sup',
    noSupportedMessage: 'Your browser dosn\'t support Web Audio API'
  },
  computed: {
    mount () {
      return this.radioServer + this.mountName + this.mountParams;
    },
    mountName () {
      return "/" + this.project.slug + "." + this.station.slug + ".mp3";
    },
    metaDataUrl () {
      return this.radioServer + "/status-json.xsl?mount=" + this.mountName;
    },
    mountParams () {
      return "?username=" + this.user.username + "&password=" + this.user.remember_token;
    }
  },
  mounted () {
    this.ctx = this.initAudioContext();
    this.playerContainer = this.initPlayerContainer();
    return this.audio = this.initAudioElement();
  },
  watch: {
    volume (vol) {
      if (this.audio) {
        return this.audio.volume = vol;
      }
    },
    playing (play) {
      if (play) {
        return this.addInterval('metaInterval', this.getMetaData, 5000);
      } else {
        return this.resetInterval('metaInterval');
      }
    }
  },
  methods: {
     /**
     * Init audio context
     * @return {AudioContext} new audio context
     */
    initAudioContext () {
      if (window.AudioContext) {
        return this.ctx || new AudioContext();
      }
    },

    /**
     * Select parent of audio element
     * @return {HTMLElement}
     */
    initPlayerContainer () {
      return this.$el.getElementsByClassName('player-container')[0];
    },

    /**
     * Init source of audio element
     * @return {Audio} HTML element
     */
    initAudioElement () {
      var audio, noSup;
      noSup = document.createElement('div');
      noSup.className = this.noSupportedClass;
      noSup.innerHTML = this.noSupportedMessage;
      audio = new Audio();
      audio.src = this.streamUrl;
      // audio.src = this.mount;
      audio.crossOrigin = 'anonymous';
      audio.controls = 'true';
      audio.onplay = this.onPlay;
      audio.onpause = this.onPause;
      audio.onabort = this.onAbort;
      audio.onerror = this.onError;
      audio.onwheel = this.onWheel;
      audio.oncanplay = this.onCanPlay;
      audio.oncanplaythrough = this.onCanPlay;
      audio.onvolumechange = this.onVolumeChange;
      audio.appendChild(noSup);
      if (this.playerContainer.childElementCount && this.audio) {
        return this.playerContainer.replaceChild(audio, this.audio);
      }
      return this.playerContainer.appendChild(audio);
    },

    /**
     * Click on play button
     */
    play () {
      if (!this.playing && this.audio && this.audio.networkState === 2) {
        return this.audio.play().then(this.playStarted)["catch"](this.onError);
      }
    },

    /**
     * Play starts successfully
     */
    playStarted () {
      this.getMetaData();
      return this.resetTimeout('reloadTimeout');
    },

    /**
     * Click on pause button
     */
    pause () {
      if (this.playing) {
        this.audio.pause();
      }
      return this.metadata = null;
    },

    /**
     * Force reload stream
     */
    tryToReload () {
      this.audio.src = this.mount;
      this.audio.load();
      return this.play();
    },

    /**
     * Set periodic func call & store interval ID in comp data
     * @param {String}   intName        interval name
     * @param {Function} cb             callback
     * @param {Number}   delay=3000     timeout
     */
    addInterval (intName, cb, delay) {
      if (delay == null) {
        delay = 3000;
      }
      return this[intName] = this[intName] || window.setInterval(cb, delay);
    },

    /**
     * Remove call interval and ID
     * @param  {String} intName        interval name
     */
    resetInterval (intName) {
      var id;
      id = this[intName];
      if (id) {
        window.clearInterval(id);
        return this[intName] = null;
      }
    },

    /**
     * Set delay func call & store timeout ID in comp data
     * @param {String}   timeoutName    timeout name
     * @param {Function} cb             callback
     * @param {Number}   delay=3000     timeout
     */
    addTimeout (timeoutName, cb, delay) {
      if (delay == null) {
        delay = 3000;
      }
      window.clearTimeout(this[timeoutName]);
      return this[timeoutName] = window.setTimeout(cb, delay);
    },

    /**
     * Remove call timeout and ID
     * @param  {String} timeoutName        timeout name
     */
    resetTimeout (timeoutName) {
      var id;
      id = this[timeoutName];
      if (id) {
        window.clearTimeout(id);
        return this[timeoutName] = null;
      }
    },

    /****************
     * Audio Events *
    ***************
     */

    /**
     * When loaded enough data to play
     * @param  {Event} e
     */
    onCanPlay (e) {
      var audio;
      this.canPlay = true;
      this.getMetaData();
      audio = e && e.target || this.audio;
      e.target.volume = this.volume;
      if (this.ctx && !this.source) {
        this.source = this.ctx.createMediaElementSource(audio);
        return this.source.connect(this.ctx.destination);
      } else if (!this.ctx) {
        return this.play();
      } else if (audio.readyState === !0 && audio.networkState === 2) {
        return this.play();
      }
    },

    /**
     * When play starts
     */
    onPlay (e) {
      console.log(e);
      return this.playing = true;
    },

    /**
     * When play stops
     */
    onPause (e) {
      console.log(e);
      return this.playing = false;
    },

    /**
     * When stream aborted
     */
    onAbort (e) {
      return console.log(e);
    },

    /**
     * When stream throw error
     */
    onError (e) {
      console.log(e);
      this.canPlay = false;
      if (this.audio.getAttribute('preload')) {
        return this.addTimeout('reloadTimeout', this.tryToReload);
      }
    },

    /**
     * When volume change
     * @param  {Event} e
     */
    onVolumeChange (e) {
      return this.volume = e.target.volume;
    },

    /**
     * When scroll above el change vol
     * @param  {Event} e
     */
    onWheel (e) {
      var check;
      check = this.volume - e.deltaY / 1000;
      if ((1 > check && check > 0)) {
        e.preventDefault();
      }
      if (check > 1) {
        check = 1;
      }
      if (check < 0) {
        check = 0;
      }
      return this.volume = check;
    },

    /**********************
     * Metadata functions *
    *********************
     */

    /**
     * Metadata fetch Promise
     * @return {Promise}
     */
    getMetaData () {
      return this.$http.get(this.metaDataUrl, {
        before: this.metaBefore
      }).then(this.metaOk)["catch"](this.metaError);
    },

    /**
     * Check metadata item exists
     * @param  {String} key
     * @return {Boolean}
     */
    metaExists (key) {
      return this.metadata && this.metadata[key] || this.metadata && this.metadata.source && this.metadata.source[key];
    },

    /**
     * Get meta field value by key
     * @param  {String} key
     * @return {Mixed}
     */
    getMetaField (key) {
      return this.metadata && this.metadata.source && this.metadata.source[key] || this.metadata && this.metadata[key];
    },

    /**
     * On success metadata
     * @param  {Response} response
     */
    metaOk (response) {
      this.metadata = response.data.icestats;
      return this.lastPlayed = this.metadata && this.metadata.source && this.metadata.source.title;
    },

    /**
     * Before metadata query
     * @param  {Request} request
     */
    metaBefore (request) {
      return delete request.headers.map['X-CSRF-TOKEN'];
    },

    /**
     * On error metadata
     * @param  {[type]} error [description]
     * @return {[type]}       [description]
     */
    metaError (error) {
      return this.resetInterval('metaInterval');
    }
  }
})