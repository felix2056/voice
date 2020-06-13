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
          <span class="dark-logo">
            <img
              :src="'/storage/site/' + getSettingsByIndex('logo')"
              :alt="getSettingsByIndex('site_name')"
            />
          </span>
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
            <li class="search-box">
              <a class="nav-link hidden-sm-down" href="javascript:void(0)">
                <i class="mdi mdi-magnify"></i>
              </a>

              <form class="app-search" style="display: none;">
                <input type="text" class="form-control" placeholder="Search &amp; enter" />
                <a class="srh-btn">
                  <i class="ti-close"></i>
                </a>
              </form>
            </li>

            <!-- Notifications -->
            <notifications />

            <li class="dropdown tasks-menu">
              <router-link
                :to="{ name: 'Conversations' }"
                class="dropdown-toggle"
                data-toggle="dropdown"
              >
                <i class="mdi mdi-message"></i>
              </router-link>
            </li>

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
            <!-- <li>
              <a href="#" data-toggle="control-sidebar">
                <i class="fa fa-cog fa-spin"></i>
              </a>
            </li> -->
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
          <li>
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

          <li>
            <router-link :to="{ name: 'Members' }">
              <i class="icon-people"></i>
              <span>Members</span>
            </router-link>
          </li>

          <li class="treeview">
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
          </li>

          <li>
            <router-link :to="{ name: 'ChatRoom' }">
              <i class="icon-envelope"></i>
              <span>Chat</span>
            </router-link>
          </li>

          <li>
            <router-link :to="{ name: 'Pricing' }">
              <i class="icon-paypal"></i>
              <span>Pricing</span>
            </router-link>
          </li>

          <li v-if="$is('Admin') || $is('Broadcaster')" class="header nav-small-cap">BROADCASTERS</li>

          <li v-if="$is('Admin') || $is('Broadcaster')">
            <a href="#" data-toggle="modal" data-target="#modal-fill">
              <i class="icon-microphone"></i>
              <span>Broadcast</span>
            </a>
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

            <div class="alert" id="alert-answer" :class="alert.class" tyle="display: none">        
              <h4><i :class="'icon ' + alert.icon"></i> {{ alert.header }}</h4>
              <p>{{ alert.body }}</p>
            </div>

            <audio v-show="broadcasting" id="remoteAudio" autoplay></audio>
          </div>
          <div class="modal-footer">
            <button type="button" @click="answerBroadcast()" :disabled="!broadcastAvailable" class="btn btn-app bg-yellow">
              <i class="fa fa-play"></i> Play
            </button>

            <button type="button" :disabled="!broadcastAvailable" class="btn btn-app bg-purple">
              <i class="fa fa-pause"></i> Pause
            </button>

            <button type="button" @click="leaveBroadcast()" :disabled="!broadcastAvailable" class="btn btn-app bg-teal">
              <i class="fa fa-stop"></i> Stop
            </button>
          </div>
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
            <h3 class="modal-title">Start A Broadcast</h3>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Create a live audio broadcast and stream it to all premium members in real time</p>
            <br />
            <br />
            
            <div class="callout" id="callout" :class="callout.class" style="display: none">
              <h4><i :class="'icon ' + callout.icon"></i> {{ callout.header }}</h4>
              <h5 class="text-right">Connected users: <span class="badge badge-info"> {{ connectedUsers  }}</span></h5>

              <p>{{ callout.body }} <rotate-square5 v-if="loading" class="video__spinner"></rotate-square5></p>
            </div>

             <audio v-show="broadcasting" id="localAudio" autoplay controls muted></audio>
            <br />
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button> -->

            <button type="button" @click="requestBroadcast()" class="btn btn-app bg-green">
              <i class="fa fa-microphone"></i> Start
            </button>

            <button type="button" class="btn btn-app bg-yellow">
              <i class="fa fa-play"></i> Play
            </button>

            <button type="button" class="btn btn-app bg-purple">
              <i class="fa fa-pause"></i> Pause
            </button>

            <button type="button" @click="endBroadcast()" class="btn btn-app bg-teal">
              <i class="fa fa-stop"></i> Stop
            </button>

            <!-- <button type="button" class="btn btn-bold btn-pure btn-primary float-right">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { RotateSquare5 } from "vue-loading-spinner";
import { servers } from './utils/ICEServers';
import { log } from "./utils/logging";

import notifications from "./Notifications";

import { mapGetters } from "vuex";

export default {
  components: {
    RotateSquare5,
    notifications
  },

  data() {
    return {
      user: Laravel.user,
      csrf_token: Laravel.csrfToken,

      broadcasting: false,
      isBroadcaster: false,

      //disables the play button for users if no broadcast is available
      broadcastAvailable: false,

      //audio
      myAudio: {},

      //offer received from person who requested video call
      offer: null,

      // Media config Voice Call
      broadcastConstraints: {
        audio: {
          echoCancellation: true,
          noiseSuppression: true, 
          autoGainControl: false
        },
        video: false
      },

      // local & remote video stream
      localStream: undefined,
      remoteStream: undefined,
      
      // STUN ice servers
      configuration: servers,

      // Peer connection
      pc: undefined,
      
      // Offer config
      offerOptions: {
        offerToReceiveAudio: 1,
        offerToReceiveVideo: 1
      },

      connectedUsers: 0,

      loading: false,

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
      }
    };
  },

  computed: {
    ...mapGetters(["getSettingsByIndex"])
  },

  async mounted() {
    await this.initializeBroadcast();
  },

  methods: {
    async initializeBroadcast() {
      log(
          `${this.user.name} initializing and setting up in case of broadcast`
        );

        Echo.private("broadcast").listen(
          "NewBroadcast",
          data => {
            if (data.type === "signal") {
              this.onSignalMessage(data);
            } else {
              console.log("received unknown message type");
            }
          }
        );

        // Set the audio and audio element in case there would be need for them
        this.myAudio = document.getElementById("localAudio");
        this.remoteAudio = document.getElementById('remoteAudio');

        log(this.myAudio)

        // Create peer connection
        this.createPeerConnection();

        // Event listeners
        this.onIceCandidates();
        this.onAddStream();  
    },
    
    async requestBroadcast() {
      if (this.broadcasting) {
        return;
      }

      this.loading = true;

      log(`${this.user.name} wants to start a broadcast`);
      this.callout.class = 'callout-info';
      this.callout.icon = 'fa fa-info';
      this.callout.header = 'Initailizing broadcast..';
      this.callout.body = `${this.user.name} wants to start a broadcast`;

      this.isBroadcaster = true;

      $('#callout').fadeIn(500);

      await this.getUserVoiceMedia();
      await this.getAudio();

      this.startBroadcast();
    },

    async getUserVoiceMedia() {
      log(`Requesting ${this.user.name} voice stream`);
      this.callout.body = `Requesting ${this.user.name} voice stream`;
      this.alert.body = `Requesting ${this.user.name} voice stream`;

      if ("mediaDevices" in navigator) {
        try {
          const stream = await navigator.mediaDevices.getUserMedia(this.broadcastConstraints)
            || navigator.mediaDevices.webkitGetUserMedia(this.broadcastConstraints)
            || navigator.mediaDevices.mozGetUserMedia(this.broadcastConstraints);

          this.myAudio.srcObject = stream;
          this.localStream = stream;
          
          log("Received local voice stream");
          //callout for admin
          this.callout.class = 'callout-warning';
          this.callout.icon = 'fa fa-warning';
          this.callout.header = `Receiving broadcast..`;
          this.callout.body = 'Getting user voice media';

          //alert for members
          this.alert.class = 'alert-warning';
          this.alert.icon = 'fa fa-warning';
          this.alert.header = `Receiving broadcast..`;
          this.alert.body = 'Getting user voice media';
        } catch (error) {
          this.loading = false;

          log(`getUserMedia error: ${error}`);
          //callout for admin
          this.callout.class = 'callout-danger';
          this.callout.icon = 'fa fa-ban';
          this.callout.header = 'Failed to start broadcast..';
          this.callout.body = `You need to give permission to use your microphone. GetUserMedia error: ${error}`;

          //alert for members
          this.alert.class = 'alert-danger';
          this.alert.icon = 'fa fa-ban';
          this.alert.header = 'Failed to start broadcast..';
          this.alert.body = `You need to give permission to use your microphone. GetUserMedia error: ${error}`;
        }
      }
    },

    getAudio() {
      const audio = this.localStream.getAudioTracks();
      if (audio.length > 0) {
        log(`Using audio device: ${audio[0].label}`);

        //callout for admin
        this.callout.class = 'callout-warning';
        this.callout.icon = 'fa fa-warning';
        this.callout.header = `Broadcast received..`;
        this.callout.body = `Using audio device: ${audio[0].label}`;

        //alert for members
        this.alert.class = 'alert-warning';
        this.alert.icon = 'fa fa-warning';
        this.alert.header = `Broadcast received..`;
        this.alert.body = `Using audio device: ${audio[0].label}`;
      }
    },

    // Send signaling data via Scaledrone
    async sendSignal(details) {
      let user = this.user.id;
      log(details['content'])

      var message = { from: user, type: details['type'], subtype: details['subtype'], content: details['content'], time: new Date() };
      await axios.post('/trigger-broadcast', {message: message});
    },

    startBroadcast() {
      // Add local stream
      this.addLocalStream();
      this.broadcasting = true;

      if (this.isBroadcaster) {
        this.createBroadcast();
      } else {
        this.createAnswer()
      }
    },

    createPeerConnection() {
      this.pc = new RTCPeerConnection(this.configuration);
      log(`${this.user.name} Created peer connection object`);
    },

    addLocalStream(){
      this.pc.addStream(this.localStream)
    },

    onIceCandidates() {
      // send any ice candidates to the other peer
      log(`${this.user.name} starting onice candidate`);
      var limit = 0;
      
      this.pc.onicecandidate = ({ candidate }) => {
        if (limit == 0) {
          var details = [];
            
          details['type'] = 'signal';
          details['subtype'] = 'candidate';
          details['content'] = candidate;
          
          this.sendSignal(details);

          //Limit the number of ICEs to be sent to avoid recuring multiple times
          limit = 1;
        } else {
          return;
        }
      };
    },

    onAddStream() {
      log(`${this.user.name} starting onadd stream`);

      this.pc.onaddstream = (event) => {
        if(!this.remoteAudio.srcObject && event.stream) {
          this.remoteStream = event.stream
          this.remoteAudio.srcObject = this.remoteStream;
        }
      }
    },

    createBroadcast() {
      log(`${this.user.name} wants to start a broadcast`); 
      this.callout.class = 'callout-warning';
      this.callout.icon = 'fa fa-warning';
      this.callout.header = 'Sending Broadcast...';
      this.callout.body = `Sending broadcast to all premium members..`;  
      this.createOffer();
    },

    async setRemoteDescription(remoteDesc) {
      try {
        log(`${this.user.name} setRemoteDescription: start`);
        await this.pc.setRemoteDescription(remoteDesc);
        
        log(`${this.user.name} setRemoteDescription: finished`);
      } catch (error) {
        log(`Error setting the RemoteDescription with ${this.user.name}. Error: ${error}`);
      }
    },

    async createAnswer() {
      log(`${this.user.name} create an answer: start`);
      try {
        const answer = await this.pc.createAnswer();

        log(`Answer from ${this.user.name}\n ${answer.sdp}`);
        log(`${this.user.name} setLocalDescription: start`);
                
        await this.pc.setLocalDescription(answer);
                
        log(`${this.user.name} setLocalDescription: finished`);
        
        this.alert.class = 'alert-success';
        this.alert.icon = 'fa fa-check';
        this.alert.header = 'Answering Broadcast...';
        this.alert.body = `${this.user.name} has joined the broadcast`;

        this.sendSignalingMessage(this.pc.localDescription, false);
      } catch (error) {
        log(`Error creating the answer from ${this.user.name}. Error: ${error}`);

        this.alert.class = 'alert-danger';
        this.alert.icon = 'fa fa-ban';
        this.alert.header = 'Failed To Join Broadcast...';
        this.alert.body = `Error creating the answer from ${this.user.name}. Error: ${error}`;
      }
    },

    async createOffer() {
      log(`${this.user.name} create an offer: start`);
            
      try {
        const offer = await this.pc.createOffer(this.offerOptions);

        log(`Offer from ${this.user.name}\n ${offer.sdp}`);
        log(`${this.user.name} setLocalDescription: start`);
                
        await this.pc.setLocalDescription(offer);
                
        log(`${this.user.name} setLocalDescription: finished`);

        this.callout.class = 'callout-success';
        this.callout.icon = 'fa fa-check';
        this.callout.header = 'Initialization Completed..';
        this.callout.body = `${this.user.name} finished creating offer. Now waiting for members to join the broadcast.`;

        this.loading = false;
                
        this.sendSignalingMessage(this.pc.localDescription, true);
      } catch (error) {
        log(`Error creating the offer from ${this.user.name}. Error: ${error}`);
        
        this.callout.class = 'callout-danger';
        this.callout.icon = 'fa fa-ban';
        this.callout.header = 'Initialization Failed!';
        this.callout.body = `Error creating the offer from ${this.user.name}. Error: ${error}`;
      }
    },

    sendSignalingMessage(desc, offer) {
      const isOffer = offer ? "offer" : "answer";
      log(`${this.user.name} sends the ${isOffer} through the signal channel`);
      
      // send the offer to the other peer
      var details = [];
            
      details['type'] = 'signal';
      details['subtype'] = isOffer;
      details['content'] = desc;
      
      this.sendSignal(details);
    },

    onSignalMessage(m) {
      log(m.subtype);
      this.broadcastAvailable = true;

      if(m.subtype === 'offer') {
        log('got remote offer from ' + m.from + ', content ' + m.content);
        this.onSignalOffer(m.content);
      } else if(m.subtype === 'answer') {
        this.onSignalAnswer(m.content);
      } else if(m.subtype === 'candidate') {
        log('got remote candidate from ' + m.from + ', content ' + m.content);
        this.onSignalCandidate(m.content);
      } else if(m.subtype === 'leave') {
        this.onSignalLeave();
      } else if(m.subtype === 'close') {
        this.onSignalClose();
      } else {
        console.log('unknown signal type ' + m.subtype);
      }
    },

    async onSignalOffer(offer) {
      log('onsignal offer')
      this.offer = offer;
      
      //alert for members
      this.alert.class = 'alert-success';
      this.alert.icon = 'fa fa-check';
      this.alert.header = this.getSettingsByIndex('site_name') + ` Started A Broadcast!`;
      this.alert.body = 'Broadcast has started. To listen, join the broadcast by clicking on the play button';
            
      var data = {
        type: this.offer.type,
        sdp: this.offer.sdp += "\n"
      }
      
      await this.setRemoteDescription(data);      
      $('#alert-answer').fadeIn(500);
    },

    async answerBroadcast() {
      this.isBroadcaster = false;
      log(`Requesting ${this.user.name} video stream`);
      
      await this.getUserVoiceMedia();
      await this.getAudio();

      this.startBroadcast();
      
    },

    async onSignalAnswer(answer) {
      log('onRemoteAnswer : ' + answer);

      var data = {
        type: answer.type,
        sdp: answer.sdp += "\n"
      }
      
      await this.setRemoteDescription(data);
      this.onSetRemoteSuccess(this.pc);
    },

    onSetRemoteSuccess(pc) {
      Toast.fire({
        type: "success",
        title: "New user connected!"
      });

      this.connectedUsers += 1;
      log(pc + ' setRemoteDescription complete');
    },

    async onSignalCandidate(candidate) {
      try {
        log(`${this.user.name} attempting to add a candidate`);
        await this.pc.addIceCandidate(new RTCIceCandidate(candidate));
        log(`Candidate added`);
      } catch (error) {
        log(`Error adding a candidate in ${this.user.name}. Error: ${error}`)
      }
    },

    onSignalLeave() {
      this.connectedUsers -= 1;
    },

    onSignalClose() {
      log('Ending broadcast');
      
      this.leaveBroadcast();
    },
    
    //Video call already going on and member wants to end it
    async endBroadcast() {
      $('#modal-fill').modal('hide');

      Swal.fire({
        title: "Are You Sure?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Stop Broadcast"
      }).then(result => {
        if (result.value) {
          let details = [];

          details['type'] = 'signal';
          details['subtype'] = 'close';
          details['content'] = 'ending the broadcast';


          log('Ending broadcast');
          this.callout.class = 'callout-danger';
          this.callout.icon = 'fa fa-danger';
          this.callout.header = 'Killing broadcast..';
          this.callout.body = `${this.user.name} wants to end the broadcast`;

          this.sendSignal(details);

          this.pc.close();
          this.pc = null;

          this.broadcasting = false;

          this.closeMedia();
          this.clearView();
        }
      });
    },

    leaveBroadcast() {
      //member wants to leave the broadcast
      this.alert.class = 'alert-danger';
      this.alert.icon = 'fa fa-ban';
      this.alert.header = `Leaving broadcast..`;
      this.alert.body = `${this.user.name} has left the broadcast.`;

      let details = [];

      details['type'] = 'signal';
      details['subtype'] = 'leave';
      details['content'] = 'leaving the broadcast';

      this.sendSignal(details);

      this.pc.close();
      this.pc = null;

      this.broadcasting = false;
                
      this.closeMedia();
      this.clearView();
    },

    closeMedia() {
      this.localStream.getTracks().forEach(function(track){track.stop();});
    },

    clearView() {
      this.myAudio.srcObject = null;
      this.remoteAudio.srcObject = null;
      
      Toast.fire({
        type: "success",
        title: "You left the broadcast!"
      });
    },

    logout() {
      document.getElementById("logout-form").submit();
    }
  }
};
</script>

<style>
.skin-yellow .sidebar-menu>li:hover>a, .skin-yellow .sidebar-menu>li >a.router-link-exact-active, .skin-yellow .sidebar-menu>li.menu-open>a{
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