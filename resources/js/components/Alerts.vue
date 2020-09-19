<template>
  <div class="alerts dashbord-notification">
    <!-- Messages alerts -->
    <div
      id="alertbottomright"
      class="myadmin-alert myadmin-alert-img alert-info myadmin-alert-bottom-right"
      style="display: none;"
    >
      <router-link :to="{ name: 'Chat', params: { slug: slug  } }">
        <img :src="avatar" class="img" :alt="user" />
      </router-link>

      <a href="#" @click="closeMessage" class="closed">×</a>

      <h4>You Have New Message!</h4>

      <router-link :to="{ name: 'Chat', params: { slug: slug  } }" style="text-decoration: none;">
        <b>{{ user }}</b> sent you a message.
      </router-link>

      <a href="#" @click="closeMessage" class="closed">×</a>
    </div>

    <!-- Mails alert -->
    <div
      class="myadmin-alert myadmin-alert-img myadmin-alert-click alert-info myadmin-alert-top alerttop2"
      style="display: none;"
    >
      <router-link :to="{ name: 'Single', params: { slug: slug  } }">
        <img :src="avatar" class="img" :alt="user" />
      </router-link>

      <a href="#" @click="closeMail" class="closed">×</a>

      <h4>You Have Mail!</h4>
      
      <router-link :to="{ name: 'Single', params: { slug: slug  } }" style="text-decoration: none;">
        <b>{{ user }}</b> sent you a new mail.
      </router-link>

      <a href="#" @click="closeMail" class="closed">×</a>
    </div>


    <div class="myadmin-alert myadmin-alert-img myadmin-alert-click alert-warning myadmin-alert-bottom alertbottom2" style="display: none;">
      <img :src="avatar" class="img" :alt="user">
      
      <a href="#" @click="closeBroadcast" class="closed">×</a>

			<h4>Incoming Broadcast!</h4> 
      <b>{{ user }}</b> has started a broadcast. Click on the squawk icon to listen to it.
      
      <a href="#" @click="closeBroadcast" class="closed">×</a>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      auth: Laravel.user,
      notChatPage: true,

      messageSound: new Audio("/sounds/newMessage.mp3"),
      mailSound: new Audio("/sounds/newMail.mp3"),
      broadcastSound: new Audio("/sounds/newBroadcast.mp3"),

      user: "",
      avatar: "",
      slug: ""
    };
  },

  computed: {
    ...mapGetters(["getSettingsByIndex"])
  },

  created() {
    this.notChatPage = this.evaluateChatPage();
  },

  mounted() {
    this.initialize();
  },

  methods: {
    evaluateChatPage() {
      // Get the substring of the path between first and second slash
      // This will allow to include any child pathing
      // NOTE: In my test the first index ([0]) was empty so used one ([1]) for the `filter`
      const entryPath = this.$router.currentRoute.path
        .split("/")
        .filter((x, i) => i === 2);

      // We want to exclude the following paths i.e. hide when on these
      // There should only be one item in the array so we extract with `[0]`

      if (entryPath[0] == "chat") {
        return false;
      }
      return true;
    },

    initialize() {
      if (this.notChatPage) {
        Echo.private('chat.' + this.auth.id).listen("NewMessage", e => {
          console.log("Message Alert:" + e);

          this.user = e.message.user.name;
          this.avatar = e.message.user.avatar_url;
          this.slug = e.message.user.slug;

          this.showMessage();
        });
      }

      Echo.private("mail").listen("NewMail", e => {
        console.log("Mail Alert:" + e);

        this.user = e.mail.user.name;
        this.avatar = e.mail.user.avatar_url;
        this.slug = e.mail.slug;

        this.showMail();
      });

      Echo.private("broadcast").listen("NewBroadcast", data => {
        console.log("Broadcast Alert:" + data);

        
          this.user = data.username;
          this.avatar = data.avatar;
          this.slug = '';

          this.showBroadcast();
        
        

        // if (data.subtype === 'offer') {
        //   this.user = this.getSettingsByIndex('site_name');
        //   this.avatar = '/storage/site/' + this.getSettingsByIndex('logo');
        //   this.slug = '';

        //   this.showBroadcast();
        // }
      });
    },

    showMessage() {
      this.messageSound.play();
      setTimeout(function() {
        $("#alertbottomright").fadeIn(350);
      }, 5000);
    },

    showMail() {
      this.mailSound.play();
      setTimeout(function() {
        $(".alerttop2").fadeIn(350);
      }, 5000);
    },

    showBroadcast() {
      this.broadcastSound.play();
      setTimeout(function() {
        $(".alertbottom2").fadeIn(350);
      }, 2000);
    },

    closeMessage() {
      this.user = "";
      this.avatar = "";
      $("#alertbottomright").fadeOut(350);
    },

    closeMail() {
      this.user = "";
      this.avatar = "";
      $(".alerttop2").fadeOut(350);
    },

    closeBroadcast() {
      this.user = "";
      this.avatar = "";
      $(".alertbottom2").fadeOut(350);
    }
  },

  watch: {
    $route() {
      this.notChatPage = this.evaluateChatPage();
    }
  }
};
</script>

<style>
</style>