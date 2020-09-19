<template>
  <div class="content-wrapper" style="min-height: 644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Broadcasts</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Broadcasts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="box">
            <div class="box-header with-border">
              <h5 class="box-title">All Broadcasts ({{ broadcasts.length }})</h5>
            </div>
            <div class="box-body p-0">
              <div class="media-list media-list-hover media-list-divided">
                <div v-for="broadcast in broadcasts" :key="broadcast.id" class="media">
                  <img class="avatar" :src="broadcast.user.avatar_url" :alt="broadcast.user.name" />

                  <div class="media-body">
                    <p>
                      <strong>{{ broadcast.user.name }}</strong>
                      <timeago
                        class="float-right"
                        :datetime="broadcast.created_at"
                        :auto-update="60"
                      ></timeago>
                    </p>

                    <audio :src="broadcast.source_url" controls :id="'broadcast_' + broadcast.id"></audio>

                    <div class="media-block-actions">
                      <nav class="nav nav-dot-separated no-gutters">
                        <div class="nav-item">
                          <button
                            @click="streamBroadcast(broadcast.id)"
                            type="button"
                            class="btn bg-green"
                          >
                            <i class="fa fa-play"></i> Stream
                          </button>
                        </div>
                        <div class="nav-item">
                          <button @click="deleteBroadcast(broadcast.id)" type="button" class="btn bg-red">
                            <i class="fa fa-times"></i> Delete
                          </button>
                        </div>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
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

      loading: false,

      broadcasts: [],
    };
  },

  async mounted() {
    await this.getBroadcasts();
  },

  methods: {
    async getBroadcasts() {
      this.loading = true;

      let url = `/all-broadcasts`;

      axios.get(url).then((response) => {
        this.broadcasts = response.data.broadcasts;
        this.loading = false;
      });
    },

    async streamBroadcast(broadcast_id) {
      this.loading = true;

      let url = `/stream-broadcast`;

      axios
        .post(url, { broadcast_id: broadcast_id })
        .then((response) => {
          Toast.fire({
            type: "success",
            title: "Broadcast now streaming!",
          });

          let broadcast = document.getElementById("broadcast_" + broadcast_id);
          broadcast.play();
        })
        .catch((error) => {
          Toast.fire({
            type: "error",
            title: "Something Went Wrong!",
          });
        });
    },

    async deleteBroadcast(broadcast_id) {
      Swal.fire({
        title: "Are You Sure?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Delete Broadcast",
      }).then((result) => {
        if (result.value) {
          this.loading = true;

          let url = `/delete-broadcast`;

          axios
            .post(url, { broadcast_id: broadcast_id })
            .then((response) => {
              this.getBroadcasts();

              Toast.fire({
                type: "success",
                title: "Successfully deleted broadcast!",
              });
            })
            .catch((error) => {
              Toast.fire({
                type: "error",
                title: "Something Went Wrong!",
              });
            });
        }
      });
    },
  },
};
</script>

<style>
</style>