<template>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- DIRECT CHAT DANGER -->
          <div class="box direct-chat direct-chat-success" id="direct-chat">
            <div class="box-header with-border">
              <h4 class="box-title">Chatroom</h4>

              <ul class="box-controls pull-right">
                <li>
                  <a class="box-btn-close" href="#"></a>
                </li>
                <li>
                  <a class="box-btn-slide" href="#"></a>
                </li>
                <li>
                  <a class="box-btn-fullscreen" href="#"></a>
                </li>
                <li>
                  <span
                    data-toggle="tooltip"
                    title
                    class="badge badge-pill badge-success"
                    data-original-title="1 New Messages"
                  >5</span>
                </li>
              </ul>
            </div>

            <div class="box-body" style>
              <div
                v-if="messages.length > 0"
                class="direct-chat-messages"
                id="chat-body"
                style="width: auto; height: 380px; overflow: auto"
              >
                <div
                  class="direct-chat-msg"
                  :class="message.user_id === user.id ? 'right' : ''"
                  v-for="message in messages"
                  :key="message.id"
                >
                  <div class="direct-chat-info clearfix">
                    <span
                      class="direct-chat-name"
                      :class="message.user_id === user.id ? 'pull-right' : 'pull-left'"
                    >{{ message.user.name }}</span>

                    <span
                      class="direct-chat-timestamp"
                      :class="message.user_id === user.id ? 'pull-left' : 'pull-right'"
                    >
                      <timeago :datetime="message.created_at" :auto-update="60"></timeago>
                    </span>
                  </div>

                  <img
                    class="direct-chat-img"
                    :src="message.user.avatar_url"
                    :alt="message.user.name"
                  />
                  <div class="direct-chat-text">{{ message.body }}</div>
                </div>
              </div>
            </div>

            <div class="box-footer">
              <form method="post">
                <div class="input-group">
                  <input
                    type="text"
                    name="message"
                    v-model="newMessage"
                    @keyup.enter="sendMessage"
                    placeholder="Type Message ..."
                    class="form-control"
                  />
                  <span class="input-group-btn">
                    <button
                      :disabled="emptyMessage"
                      @click.prevent="sendMessage"
                      class="btn btn-success"
                    >Send</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      user: Laravel.user,

      messages: [],
      newMessage: ""
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

      let url = `/chatroom`;

      axios.get(url).then(response => {
        if (response.data.messages != null) {
          this.messages = response.data.messages;
        }

        this.loading = false;

        setTimeout(function() {
          var msg_body = document.getElementById("chat-body");
          msg_body.scrollTop = msg_body.scrollHeight;
        }, 800);
      });

      Echo.private("chatroom").listen("NewChatroomMessage", e => {
        console.log(e);

        this.messages.push({
          user_id: e.chat.user_id,
          user: e.chat.user,
          body: e.chat.body,
          created_at: e.chat.created_at
        });

        setTimeout(function() {
          var msg_body = document.getElementById("chat-body");
          msg_body.scrollTop = msg_body.scrollHeight;
        }, 2000);
      });
    },

    sendMessage() {
      if (!this.user) {
        return;
      }

      if (this.newMessage == "") {
        return;
      }

      let message = this.newMessage;
      let url = `/send-message-chatroom`;

      var msg_body = document.getElementById("chat-body");

      axios
        .post(url, { message: message })
        .then(response => {
          this.messages.push(response.data.message);
          this.newMessage = "";

          setTimeout(function() {
            msg_body.scrollTop = msg_body.scrollHeight;
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