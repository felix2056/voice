<template>
  <div class="content-wrapper" style="min-height: 1923.5px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Chats</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Chat {{ otherUser.name }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="box direct-chat">
            <div class="box-header with-border">
              <h3 class="box-title">Chat with {{ otherUser.name }}</h3>
            </div>

            <div class="box-body">
              <div
                id="chat-app"
                class="direct-chat-messages chat-app"
                style="width: auto; height: 500px; overflow: auto"
              >
                <!-- Message. Default to the left -->
                <div
                  class="direct-chat-msg mb-30"
                  v-if="messages.length > 0"
                  v-for="message in messages"
                  :key="message.id"
                  :class="{ 'right': message.user_id === user.id }"
                >
                  <div class="clearfix mb-15">
                    <span class="direct-chat-name" :class="message.user_id === user.id ? 'pull-right' : 'pull-left'">{{ message.user.name }}</span>

                    <span class="direct-chat-timestamp" :class="message.user_id === user.id ? 'pull-left' : 'pull-right'">
                      <timeago :datetime="message.created_at" :auto-update="60"></timeago>
                    </span>
                  </div>

                  <img
                    class="direct-chat-img avatar"
                    :src="message.user.avatar_url"
                    :alt="message.user.name"
                  />

                  <div class="direct-chat-text">{{ message.body }}</div>
                </div>
              </div>
            </div>

            <div class="box-footer">
              <div class="mb-20" v-if="typingUser != null" v-show="typing">
                <span class="mb-25 mt-10 text text-danger">{{ typingUser }} is typing...</span>
              </div>
              <form>
                <div class="input-group">
                  <input
                    type="text"
                    @keydown="isTyping"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    placeholder="Type Message ..."
                    class="form-control"
                  />
                  <span class="input-group-btn">
                    <button
                      type="button"
                      :disabled="emptyMessage"
                      @click.prevent="sendMessage"
                      class="btn btn-warning"
                    >Send</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: Laravel.user,
      otherUser: {},

      loading: false,

      messages: [],
      newMessage: "",

      typing: false,
      typingUser: null,

      messages: []
    };
  },

  computed: {
    emptyMessage() {
      return this.newMessage == "";
    }
  },

  async mounted() {
    await this.getMessages();
  },

  methods: {
    async getMessages() {
      let _this = this;

      this.loading = true;

      let url = `/messages/${this.$route.params.slug}`;

      axios.get(url).then(response => {
        if (response.data.messages != null) {
          this.messages = response.data.messages;
        }

        this.otherUser = response.data.otherUser;

        var chat_body = document.getElementById("chat-app");

        this.loading = false;

        setTimeout(function() {
          chat_body.scrollTop = chat_body.scrollHeight;
        }, 200);
      });

      Echo.private("chat")
        .listen("NewMessage", e => {
          console.log(e);

          this.messages.push({
            id: e.message.id,
            user_id: e.message.user_id,
            user: e.message.user,
            body: e.message.body,
            created_at: e.message.created_at
          });

          var chat_body = document.getElementById("chat-app");

          setTimeout(function() {
            chat_body.scrollTop = chat_body.scrollHeight;
          }, 200);
        })
        .listenForWhisper("typing", e => {
          this.typingUser = e.typingUser;
          this.typing = e.typing;

          // remove is typing indicator after 0.9s
          setTimeout(function() {
            _this.typing = false;
          }, 9000);
        });
    },

    isTyping() {
      let channel = Echo.private("chat");
      let self = this;

      setTimeout(function() {
        channel.whisper("typing", {
          typingUser: self.user.name,
          typing: true
        });
      }, 3000);
    },

    notTyping() {
      this.typing = false;
    },

    sendMessage() {
      if (this.newMessage == "") {
        return;
      }

      let user_id = this.otherUser.id;
      let message = this.newMessage;

      let url = `/send-message/${user_id}`;

      axios
        .post(url, { user_id: user_id, message: message })
        .then(response => {
          this.messages.push(response.data.message);
          this.newMessage = "";

          var chat_body = document.getElementById("chat-app");

          setTimeout(function() {
            chat_body.scrollTop = chat_body.scrollHeight;
          }, 200);
        })
        .catch(error => {
          error.response.data.error.message
            ? (this.errors.message = error.response.data.error.message)
            : null;
        });
    }
  }
};
</script>

<style>
</style>