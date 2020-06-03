<template>
  <li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="mdi mdi-bell"></i>
      <span v-if="unreadNotifications != null && unreadNotifications.length != 0" class="badge badge-pill badge-danger" style="font-size: 14px;">{{ unreadNotifications.length > 10 ? '9+' : unreadNotifications.length }}</span>
    </a>
    <ul class="dropdown-menu scale-up">
      <li class="header">You have {{ unreadNotifications.length }} unread notifications</li>
      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu inner-content-div" style="overflow: auto; width: auto; height: 200px;">
          <h5 class="mt-80 text-center" v-if="notifications" v-show="!notifications.length">No New Notifications!</h5>

          <li
            :class="notification.read_at != null ?  ' read' : ' unread'"
            v-if="notifications && notifications.length != 0"
            v-for="notification in notifications"
            :key="notification.id"
          >
            <a :href="notification.data.link" @click.prevent="markAsRead(notification)">
              <i :class="notification.data.icon"></i> {{ notification.data.message }}
            </a>
          </li>
        </ul>
      </li>
      <!-- <li class="footer">
        <a href="#">View all</a>
      </li> -->
    </ul>
  </li>
</template>

<script>
export default {
  data() {
    return {
      notifications: []
    };
  },

  computed: {
    unreadNotifications() {
      if (!this.notifications && !this.notifications.length) {
        return null;
      }
      return this.notifications.filter(notification => {
        return notification.read_at == null;
      });
    }
  },

  mounted() {
    this.getNotifications().then(() => {
      this.setNotificationInteval();
    });
  },

  methods: {
    async setNotificationInteval() {
      setInterval(function() {
        this.getNotifications();
      }, 30000);
    },

    async getNotifications() {
      let url = `/notifications`;

      await axios
        .get(url)
        .then(response => {
          this.notifications = response.data.notifications;
        })
        .catch(err => {
          console.log(err.response);
        });
    },

    async markAsRead(notification) {
      const id = notification.id;
      const url = `/markAsRead`;

      notification.read_at = "now";
      axios.post(url, { id }).then(() => {
        window.location.href = notification.data.link;
      });
    }
  }
};
</script>

<style>
.read {
    background: #2f2f2f;
}
</style>