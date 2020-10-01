<template>
  <div class="voice-navbar">
    <header class="main-header">
      <router-link :to="{ name: 'Home'}" class="logo">
        <b class="logo-mini">
          <span class="light-logo">
            <img
              :src="'/storage/site/' + getSettingsByIndex('logo')"
              :alt="getSettingsByIndex('site_name')"
            />
          </span>
          <!-- <span class="dark-logo">
            <img
              :src="'/storage/site/' + getSettingsByIndex('logo')"
              :alt="getSettingsByIndex('site_name')"
            />
          </span> -->
        </b>

        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <img
            :src="'/storage/site/' + getSettingsByIndex('logo')"
            :alt="getSettingsByIndex('site_name')"
            class="light-logo"
          />
          <img
            :src="'/storage/site/' + getSettingsByIndex('logo')"
            :alt="getSettingsByIndex('site_name')"
            class="dark-logo"
          />
        </span>
      </router-link>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- <li class="search-box">
              <a class="nav-link hidden-sm-down" href="javascript:void(0)">
                <i class="mdi mdi-magnify"></i>
              </a>

              <form class="app-search" style="display: none;">
                <input type="text" class="form-control" placeholder="Search &amp; enter" />
                <a class="srh-btn">
                  <i class="ti-close"></i>
                </a>
              </form>
            </li> -->

            <!-- Notifications -->
            <notifications />

            <!-- <li class="dropdown tasks-menu">
              <router-link
                :to="{ name: 'Conversations' }"
                class="dropdown-toggle"
                data-toggle="dropdown"
              >
                <i class="mdi mdi-message"></i>
              </router-link>
            </li> -->

            <!-- User Account -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img :src="user.avatar_url" class="user-image rounded-circle" :alt="user.name" />
              </a>
              <ul class="dropdown-menu scale-up">
                <!-- User image -->
                <li class="user-header">
                  <img :src="user.avatar_url" class="float-left rounded-circle" :alt="user.name" />

                  <p>
                    {{ user.name }}
                    <small class="mb-5">{{ user.email }}</small>

                    <router-link
                      :to="{ name: 'Profile', params: { slug: user.slug  } }"
                      class="btn btn-danger btn-sm btn-rounded"
                    >View Profile</router-link>
                  </p>
                </li>

                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row no-gutters">
                    <div class="col-12 text-left">
                      <router-link :to="{ name: 'Profile', params: { slug: user.slug  } }">
                        <i class="ion ion-person"></i> My Profile
                      </router-link>
                    </div>

                    <div class="col-12 text-left">
                      <router-link :to="{ name: 'Mailbox'}">
                        <i class="ion ion-email-unread"></i> Inbox
                      </router-link>
                    </div>

                    <div v-if="$is('Admin')" class="col-12 text-left">
                      <router-link :to="{ name: 'Settings'}">
                        <i class="ion ion-settings"></i> Setting
                      </router-link>
                    </div>

                    <div role="separator" class="divider col-12"></div>

                    <div class="col-12 text-left">
                      <a href="/logout" @click.prevent="logout()">
                        <i class="fa fa-power-off"></i> Logout
                      </a>
                    </div>
                  </div>
                </li>
              </ul>
            </li>

            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar">
                <i class="fa fa-comments"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <section class="sidebar" style="height: auto;">
        <div class="user-panel">
          <div class="ulogo">
            <a href="/">
              <span>
                <b>{{ getSettingsByIndex('site_name') }}</b> HOME
              </span>
            </a>
          </div>

          <div class="image">
            <img :src="user.avatar_url" class="rounded-circle" :alt="user.name" />
          </div>

          <div class="info">
            <p>{{ user.name }}</p>
            <router-link
              :to="{ name: 'Settings' }"
              class="link"
              data-toggle="tooltip"
              title
              data-original-title="Settings"
            >
              <i class="ion ion-gear-b"></i>
            </router-link>

            <router-link
              :to="{ name: 'Mailbox' }"
              class="link"
              data-toggle="tooltip"
              title
              data-original-title="Email"
            >
              <i class="ion ion-android-mail"></i>
            </router-link>

            <a
              href="/logout"
              @click.prevent="logout()"
              class="link"
              data-toggle="tooltip"
              title
              data-original-title="Logout"
            >
              <i class="ion ion-power"></i>
            </a>
          </div>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
          <li class="nav-devider"></li>
          <li class="header nav-small-cap">GENERAL</li>
          <li v-if="!$is('Viewer')">
            <router-link :to="{ name: 'Home' }">
              <i class="icon-home"></i>
              <span>Dashboard</span>
            </router-link>
          </li>

          <li>
            <router-link :to="{ name: 'Newsfeed' }">
              <i class="icon-feed"></i>
              <span>Newsfeed</span>
            </router-link>
          </li>

          <!--Show different member page for admin and users-->
          <li v-if="$is('Admin')">
            <router-link :to="{ name: 'Users' }">
              <i class="icon-people"></i>
              <span>Users</span>
            </router-link>
          </li>

          <li v-if="!$is('Viewer')">
            <router-link :to="{ name: 'Members' }">
              <i class="icon-people"></i>
              <span>Members</span>
            </router-link>
          </li>

          <!-- <li class="treeview">
            <a href="#">
              <i class="fa fa-envelope"></i>
              <span>Mailbox</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-right pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <router-link :to="{ name: 'Mailbox' }">Inbox</router-link>
              </li>
              <li>
                <router-link :to="{ name: 'Compose' }">Compose</router-link>
              </li>
            </ul>
          </li>-->

          <!-- <li>
            <router-link :to="{ name: 'ChatRoom' }">
              <i class="icon-envelope"></i>
              <span>Chat</span>
            </router-link>
          </li>-->

          <!-- <li>
            <router-link :to="{ name: 'Billing' }">
              <i class="icon-wallet"></i>
              <span>Billing</span>
            </router-link>
          </li> -->

          <!-- <li>
            <router-link :to="{ name: 'Pricing' }">
              <i class="icon-paypal"></i>
              <span>Pricing</span>
            </router-link>
          </li> -->

          <li v-if="$is('Admin') || $is('Broadcaster')" class="header nav-small-cap">BROADCASTERS</li>

          <li v-if="$is('Admin') || $is('Broadcaster')">
            <a href="#" data-toggle="modal" data-target="#modal-fill">
              <i class="icon-microphone"></i>
              <span>Broadcast</span>
            </a>
          </li>

          <li v-if="$is('Admin') || $is('Broadcaster')">
            <router-link :to="{ name: 'Broadcasts' }">
              <i class="icon-volume-2"></i>
              <span>Records</span>
            </router-link>
          </li>

          <li>
            <a href="#" data-toggle="modal" data-target="#modal-left">
              <i class="icon-volume-2"></i>
              <span>Squawk</span>
            </a>
          </li>

          <li v-if="$is('Admin') || $is('Writer')" class="header nav-small-cap">WRITERS</li>

          <li v-if="$is('Admin') || $is('Writer')">
            <router-link :to="{ name: 'Write' }">
              <i class="icon-note"></i>
              <span>Write</span>
            </router-link>
          </li>

          <li v-if="$is('Admin') || $is('Writer')">
            <router-link :to="{ name: 'MyPosts' }">
              <i class="icon-list"></i>
              <span>My Posts</span>
            </router-link>
          </li>

          <li v-if="$is('Admin')" class="header nav-small-cap">ADMINS</li>

          <li v-if="$is('Admin')">
            <router-link :to="{ name: 'Settings' }">
              <i class="icon-settings"></i>
              <span>Settings</span>
            </router-link>
          </li>
        </ul>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
          <input type="hidden" name="_token" id="csrf-token" :value="csrf_token" />
        </form>
      </section>
    </aside>

    <!-- Right side column. contains easy access to the chatroom -->
    <aside class="control-sidebar control-sidebar-dark" style="height: auto; padding-bottom: 0;">
      <!-- Tab panes -->
      <div class="tab-content">
        <mini-chatroom></mini-chatroom>
      </div>
    </aside>

    <!-- Listen to broadcast -->
    <div
      class="modal modal-left fade"
      id="modal-left"
      tabindex="-1"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Listen To A Broadcast</h3>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Listen to a live broadcast</p>

            <div class="alert" id="alert-answer" :class="alert.class">
              <h4>
                <i :class="'icon ' + alert.icon"></i>
                {{ alert.header }}
              </h4>
              <p>{{ alert.body }}</p>
            </div>

            <iframe src="https://mixlr.com/users/8788133/embed?color=016478&autoplay=true" width="100%" height="180px" scrolling="no" frameborder="no" marginheight="0" marginwidth="0"></iframe>

            <audio v-show="broadcastAvailable" id="remoteAudio" controls style="display: none"></audio>
          </div>
          <!-- <div class="modal-footer">
            <button
              type="button"
              @click="playBroadcast()"
              :disabled="!broadcastAvailable"
              class="btn btn-app bg-yellow"
            >
              <i class="fa fa-play"></i> Play
            </button>

            <button
              type="button"
              @click="pauseBroadcast()"
              :disabled="!broadcastAvailable"
              class="btn btn-app bg-purple"
            >
              <i class="fa fa-pause"></i> Pause
            </button>

            <button
              type="button"
              @click="stopBroadcast()"
              :disabled="!broadcastAvailable"
              class="btn btn-app bg-teal"
            >
              <i class="fa fa-stop"></i> Stop
            </button>
          </div> -->
        </div>
      </div>
    </div>

    <div
      class="modal modal-fill fade"
      data-backdrop="false"
      id="modal-fill"
      tabindex="-1"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Record A Broadcast</h3>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Record an audio broadcast and stream it live to all premium members in real time</p>
            <br />
            <br />

            <div class="callout" id="callout" :class="callout.class" style="display: none">
              <h4>
                <i :class="'icon ' + callout.icon"></i>
                {{ callout.header }}
              </h4>
              <!-- <h5 class="text-right">
                Connected users:
                <span class="badge badge-info">{{ connectedUsers }}</span>
              </h5>-->

              <p>
                {{ callout.body }}
                <rotate-square5 v-if="loading" class="video__spinner"></rotate-square5>
              </p>
            </div>

            <div id="recording-container">
              <!-- container to house the recorded broadcast -->
              <!--for play the audio-->
              <audio v-show="recorded" id="adioPlay" autoplay controls></audio>
            </div>

            <br />
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button> -->

            <button
              type="button"
              @click="recordBroadcast()"
              :disabled="recording"
              class="btn btn-app bg-red col-md-4"
            >
              <i class="fa fa-microphone"></i>
              {{ recordMsg }}
            </button>

            <!-- <button type="button" class="btn btn-app bg-yellow">
              <i class="fa fa-play"></i> Play
            </button>

            <button type="button" class="btn btn-app bg-purple">
              <i class="fa fa-pause"></i> Pause
            </button>-->

            <button
              type="button"
              @click="stopRecording()"
              :disabled="!recording"
              class="btn btn-app bg-yellow col-md-4"
            >
              <i class="fa fa-stop"></i> Stop
            </button>

            <button
              v-if="recorded && !recording"
              @click="saveRecording()"
              type="button"
              class="btn btn-app bg-green col-md-12 mt-5"
            >
              <i class="fa fa-upload"></i> Upload
            </button>

            <div v-show="uploading" class="progress-bar col-md-12 mt-2">
              <progress max="100" :value.prop="uploadPercentage"></progress>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MiniChatroom from "./MiniChatroom";
import { RotateSquare5 } from "vue-loading-spinner";
import { log } from "./utils/logging";

import notifications from "./Notifications";

import { mapGetters } from "vuex";

export default {
  components: {
    MiniChatroom,
    RotateSquare5,
    notifications,
  },

  data() {
    return {
      user: Laravel.user,
      csrf_token: Laravel.csrfToken,

      //Stream for viewers and listeners
      broadcastAvailable: false,

      recording: false,
      recorded: false,

      broadcastConstraints: {
        audio: {
          echoCancellation: true,
          noiseSuppression: true,
          autoGainControl: false,
        },
      },

      //recording
      rec: {},
      recordedBroadcast: null,
      audioChunks: [],

      //audio
      audio: {},

      loading: false,
      uploading: false,
      uploadPercentage: 0,

      callout: {
        class: "",
        icon: "",
        header: "",
        body: "",
      },

      alert: {
        class: "",
        icon: "",
        header: "",
        body: "",
      },
    };
  },

  computed: {
    ...mapGetters(["getSettingsByIndex"]),

    recordMsg() {
      if (this.recording && !this.recorded) {
        return "Recording...";
      } else if (this.recorded && !this.recording) {
        return "Record Again";
      } else {
        return "Record";
      }
    },
  },

  mounted() {
    this.initailize();
  },

  methods: {
    async initailize() {
      let self = this;
      Echo.private("broadcast").listen("NewBroadcast", (data) => {
        let remoteAudio = document.getElementById("remoteAudio");
        remoteAudio.src = data.source;

        self.broadcastAvailable = true;

        //alert for members
        self.alert.class = "alert-success";
        self.alert.icon = "fa fa-success";
        self.alert.header = `Broadcast Available..`;
        self.alert.body = "Playing broadcast";

        this.playBroadcast();
      });
    },

    async recordBroadcast() {
      if (this.recording) {
        return;
      }

      this.loading = true;
      this.recording = true;

      //Default everything back
      this.recorded = false;

      this.rec = {};
      this.recordedBroadcast = {};
      this.audioChunks = [];
      this.audio = {};

      log(`${this.user.name} wants to record a broadcast`);
      this.callout.class = "callout-info";
      this.callout.icon = "fa fa-info";
      this.callout.header = "Initailizing broadcast recorder..";
      this.callout.body = `${this.user.name} wants to record a broadcast`;

      $("#callout").fadeIn(500);

      await this.getUserVoiceMedia();
      //await this.getAudio();
    },

    async getUserVoiceMedia() {
      let self = this;

      log(`Requesting ${this.user.name} voice stream`);
      this.callout.body = `Requesting ${this.user.name} voice stream`;
      this.alert.body = `Requesting ${this.user.name} voice stream`;

      if ("mediaDevices" in navigator) {
        //callout for admin
        this.callout.class = "callout-warning";
        this.callout.icon = "fa fa-warning";
        this.callout.header = `Preparing Media Devices`;
        this.callout.body = "Getting user permission for voice media";

        try {
          const stream =
            (await navigator.mediaDevices.getUserMedia(
              this.broadcastConstraints
            )) ||
            navigator.mediaDevices.webkitGetUserMedia(
              this.broadcastConstraints
            ) ||
            navigator.mediaDevices.mozGetUserMedia(this.broadcastConstraints);

          this.rec = new MediaRecorder(stream);

          let container = document.getElementById("recording-container");

          // 2nd audio tag for play the audio
          let playAudio = document.getElementById("adioPlay");

          this.audio = document.createElement("audio");

          // callout for admin
          this.callout.class = "callout-warning";
          this.callout.icon = "fa fa-warning";
          this.callout.header = `Stream Received!`;
          this.callout.body = "Starting voice recording";

          log("Starting voice recording");

          if ("srcObject" in this.audio) {
            this.audio.srcObject = stream;
          } else {
            this.audio.src = window.URL.createObjectURL(stream);
          }

          container.append(this.audio);

          this.audio.onloadedmetadata = function (ev) {
            self.audio.play();
          };

          this.rec.ondataavailable = function (ev) {
            self.audioChunks.push(ev.data);
          };

          // Convert the audio data in to blob
          // after stopping the recording
          this.rec.onstop = function (ev) {
            log("Stopping broadcast");

            self.callout.class = "callout-warning";
            self.callout.icon = "fa fa-danger";
            self.callout.header = "Preparing Recorded Audio";
            self.callout.body = `getting audio blob ready to send to the server!`;

            // blob of type mp3
            self.recordedBroadcast = new Blob(self.audioChunks, {
              type: "audio/mp3;",
            });

            // After fill up the chunk
            // array make it empty
            self.audioChunks = [];

            // Creating audio url with reference
            // of created blob named 'audioData'
            let audioSrc = window.URL.createObjectURL(self.recordedBroadcast);

            // Pass the audio url to the 2nd video tag and default the original audio
            playAudio.src = audioSrc;

            if ("srcObject" in self.audio) {
              self.audio.srcObject = null;
            } else {
              self.audio.src = null;
            }

            //Audio prepared and ready to upload to server
            self.callout.class = "callout-success";
            self.callout.icon = "fa fa-success";
            self.callout.header = "Recording Complete";
            self.callout.body = `You can now proceed to upload to server or record a new audio!`;

            self.recording = false;
            self.recorded = true;
          };

          //start
          this.startRecording();
        } catch (error) {
          this.loading = false;
          this.recording = false;

          log(`getUserMedia error: ${error}`);
          //callout for admin
          this.callout.class = "callout-danger";
          this.callout.icon = "fa fa-ban";
          this.callout.header = "Failed to initiate broadcast recording..";
          this.callout.body = `Make sure you give permission to use your microphone. GetUserMedia error: ${error}`;
        }
      }
    },

    startRecording() {
      this.rec.start();
      this.recording = true;

      //callout for admin
      this.callout.class = "callout-success";
      this.callout.icon = "fa fa-warning";
      this.callout.header = `Recording...`;
      this.callout.body = "Recording voice media";

      log(this.rec.state);
    },

    stopRecording() {
      log("Stopping broadcast");

      this.callout.class = "callout-danger";
      this.callout.icon = "fa fa-danger";
      this.callout.header = "Stopping Recording..";
      this.callout.body = `${this.user.name} wants to stop recording broadcast`;

      this.rec.stop();
      this.recording = false;
      this.loading = false;

      log(this.rec.state);
      //this.rec.clear();

      //$("#modal-fill").modal("hide");
    },

    saveRecording() {
      if (this.recording && !this.recorded) {
        this.callout.class = "callout-danger";
        this.callout.icon = "fa fa-danger";
        this.callout.header = "Something Went Wrong!";
        this.callout.body = `Make sure you have a valid recorded broadcast before uploading`;
        return;
      }

      if (this.recordedBroadcast == null) {
        this.callout.class = "callout-danger";
        this.callout.icon = "fa fa-danger";
        this.callout.header = "No Recorded File To Upload";
        this.callout.body = `The recorded broadcast is empty! Make sure you record a broadcast before uploading`;

        return;
      }

      this.loading = true;
      this.uploading = true;

      log("sending to server");

      let url = `/upload-broadcast`;

      let formData = new FormData();

      formData.append("audio", this.recordedBroadcast);

      let headers = { "Content-Type": "multipart/form-data" };

      axios
        .post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
          onUploadProgress: function (progressEvent) {
            this.uploadPercentage = parseInt(
              Math.round((progressEvent.loaded / progressEvent.total) * 100)
            );
          }.bind(this),
        })
        .then((success) => {
          $("#modal-fill").modal("hide");

          Toast.fire({
            type: "success",
            title: "Successfully uploaded broadcast!",
          });

          this.loading = false;
          this.uploading = false;

          this.$router.push({ name: 'Broadcasts' })
        })
    },

    playBroadcast() {
      if (this.broadcastAvailable) {
        let remoteAudio = document.getElementById("remoteAudio");
        remoteAudio.play();
      }
    },

    pauseBroadcast() {
      if (this.broadcastAvailable) {
        let remoteAudio = document.getElementById("remoteAudio");
        remoteAudio.pause();
      }
    },

    stopBroadcast() {
      if (this.broadcastAvailable) {
        let remoteAudio = document.getElementById("remoteAudio");
        remoteAudio.pause();
        remoteAudio.currentTime = 0;
      }
    },

    logout() {
      document.getElementById("logout-form").submit();
    },
  },
};
</script>

<style>
.skin-yellow .sidebar-menu > li:hover > a,
.skin-yellow .sidebar-menu > li > a.router-link-exact-active,
.skin-yellow .sidebar-menu > li.menu-open > a {
  color: #ffffff;
  background: #303030;
}

.skin-yellow .sidebar-menu > li > a.router-link-exact-active,
.skin-yellow .sidebar-menu > li.menu-open > a {
  color: #ffffff;
}
.skin-yellow .sidebar-menu > li > a.router-link-exact-active {
  border-left-color: #fbae1c;
}
</style>