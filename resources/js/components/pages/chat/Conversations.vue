<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Conversations</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Chat</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-md-12">
          <div v-if="conversation != null" class="box">
            <div class="box-header no-border bg-dark p-0 pt-10">
              <div class="form-element">
                <input
                  class="form-control text-white p-20"
                  type="text"
                  placeholder="Search Contact"
                />
              </div>
            </div>
            <div class="box-body p-0" style="overflow: auto; max-height: 70vh;">
              <div class="media-list media-list-hover media-list-divided">
                <div
                  v-for="convo in conversations"
                  :key="convo.person.id"
                  :class="{ 'open-chat': convo.id == conversation.id }"
                  @click="select(convo)"
                  class="media media-single"
                >
                  <a href="#">
                    <img
                      class="avatar avatar-xl"
                      :src="convo.person.avatar_url"
                      :alt="convo.person.name"
                    />
                  </a>

                  <div class="media-body">
                    <h6>
                      <a href="#">{{ convo.person.name }}</a>
                    </h6>

                    <small class="text-green">{{ convo.last_message[0].body.substring(0, 30) + '...' }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9 col-md-12">
          <div class="box direct-chat">
            <div class="box-header with-border">
              <h3 class="box-title">Chat with {{ conversation.person.name }}</h3>
            </div>
            <div class="box-body">
              <div
                id="chat-app"
                class="direct-chat-messages chat-app"
                style="overflow: hidden; width: auto; height: 380px; overflow: auto"
              >
                <!-- Message. Default to the left -->
                <div v-if="messages.length > 0" v-for="message in messages" :key="message.id" :class="{ 'right': message.user_id === user.id }" class="direct-chat-msg mb-30">
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

                  <div
                    class="direct-chat-text"
                  >{{ message.body }}</div>
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
                    <button :disabled="emptyMessage" @click.prevent="sendMessage" type="button" class="btn btn-warning">Send</button>
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

      conversations: [],

      //single selected conversation
      conversation: null,

      messages: [],
      newMessage: "",

      typing: false,
      typingUser: null,

      messages: []
    };
  },

  computed: {
    noChatSelected() {
      return this.conversation == null || this.conversation.length === 0;
    },

    emptyMessage() {
      return this.newMessage == "";
    }
  },

  async mounted() {
    await this.getConversations();
  },

  methods: {
    async getConversations() {
      let url = `/get-conversations`;

      axios.get(url).then(response => {
        this.conversations = response.data.conversations;

        if (this.conversation == null) {
          this.conversation = this.conversations[0];

          this.getMessages(this.conversation.id);
        }
      });
    },

    async select(conversation) {
      if (this.conversation.id == conversation.id) {
        return;
      }

      conversation.has_unread = 0;

      await this.set(conversation).then(() => {
        if (this.conversation != null) {
          this.getMessages(conversation.id);
        }
      });
    },

    async set(conversation) {
      this.conversation = conversation;
    },

    async getMessages(conversation_id) {
      let _this = this;

      this.loading = true;

      let url = `/messages-with-conversation/${conversation_id}`;
      //let url = `/get-messages/${user_id}`;

      axios.get(url).then(response => {
        if (response.data.messages != null) {
          this.messages = response.data.messages;
        }

        this.loading = false;
        this.loadingMessage = "";

        setTimeout(function() {
          var chat_body = document.getElementById("chat-app");
          chat_body.scrollTop = chat_body.scrollHeight;
        }, 2000);
      });

      Echo.private('chat.' + this.user.id)
        .listen("NewMessage", e => {
          console.log(e);

          this.messages.push({
            id: e.message.id,
            user_id: e.message.user_id,
            user: e.message.user,
            body: e.message.body,
            created_at: e.message.created_at
          });

          setTimeout(function() {
            var chat_body = document.getElementById("chat-app");
            chat_body.scrollTop = chat_body.scrollHeight;
          }, 200);
        })
        .listenForWhisper("typing", e => {
            console.log(e)

            this.typingUser = e.typingUser;
            this.typing = e.typing;

            // remove is typing indicator after 0.9s
            setTimeout(function() {
                _this.typing = false;
            }, 9000);
        });
    },

    isTyping() {
      let channel = Echo.private('chat');
      let self = this;
      setTimeout(function() {
          channel.whisper('typing', {
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

      let user_id = this.conversation.person.id;
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

          //Refresh all conversations and set the receiver to the latest convo
            this.getConversations();
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
.open-chat {
    background-color: #f9fafb;
}
</style>