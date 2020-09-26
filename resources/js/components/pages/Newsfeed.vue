<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Newsfeed</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Newsfeed</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="box">
            <div class="box-header with-border">
              <h5 class="box-title">News Headlines</h5>
            </div>
            <div class="box-body p-0">
              <div class="media-list media-list-hover media-list-divided">
                <div v-for="post in posts" :key="post.id" class="media">
                  <img class="avatar" :src="post.user.avatar_url" :alt="post.user.name" />

                  <div class="media-body">
                    <p>
                      <strong>{{ post.user.name }}</strong>
                      <timeago class="float-right" :datetime="post.created_at" :auto-update="60"></timeago>
                    </p>

                    <!-- <p v-html="post.headline"></p> -->
                    <textarea
                      v-if="editing == post.id"
                      v-model="post.headline"
                      class="form-control"
                      cols="30"
                      rows="10"
                    ></textarea>
                    <read-more
                      v-else
                      more-str="read more"
                      :text="post.headline"
                      link="#"
                      less-str="read less"
                      :max-chars="100"
                    ></read-more>

                    <div v-if="editing == post.id" class="edit">
                      <div class="pull-right">
                        <button
                          type="button"
                          @click="updateNews(post)"
                          :disabled="post.headline == ''"
                          class="btn btn-success"
                        >
                          <i v-if="updating" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                          <i v-else class="fa fa-envelope-o"></i>
                          Save Changes
                        </button>

                        <button type="button" @click="cancelEditNews" class="btn btn-success">
                          <i class="fa fa-times"></i>
                          Cancel
                        </button>
                      </div>
                    </div>

                    <div v-if="$is('Admin') || post.user.id == user.id" class="media-block-actions">
                      <nav class="nav no-gutters gap-2 font-size-16 media-hover-show">
                        <a
                          @click.prevent="deleteNews(post.id)"
                          class="nav-link text-danger"
                          href="#"
                          data-toggle="tooltip"
                          title
                          data-original-title="Delete"
                        >
                          <i class="ion-close-circled"></i>
                        </a>
                        <a
                          @click.prevent="editNews(post)"
                          class="nav-link text-danger"
                          href="#"
                          data-toggle="tooltip"
                          title
                          data-original-title="Delete"
                        >
                          <i class="ion-edit"></i>
                        </a>
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
      updating: false,
      editing: 0,

      posts: [],
    };
  },

  async mounted() {
    await this.getPosts();

    Echo.private("post").listen("NewPost", (data) => {
      console.log("Post From Newsfeed:" + data);
      this.getPosts();
    });
  },

  methods: {
    async getPosts() {
      this.loading = true;

      let url = `/posts`;

      axios.get(url).then((response) => {
        this.posts = response.data.posts;
        this.loading = false;
      });
    },

    editNews(post) {
      let str = post.headline.toString();

      post.headline = str.replace(/(<([^>]+)>)/gi, "");
      this.editing = post.id;
    },

    cancelEditNews() {
      this.editing = 0;
    },

    async updateNews(post) {
      this.updating = true;

      let url = `/update-post`;

      let id = post.id;
      let headline = post.headline;

      axios
        .post(url, { id, headline })
        .then((response) => {
          Toast.fire({
            type: "success",
            title: "Updated!",
          });

          this.updating = false;
          this.editing = 0;
          this.getPosts();
        })
        .catch((error) => {
          Toast.fire({
            type: "error",
            title: "Something Went Wrong!",
          });
        });
    },

    async deleteNews(id) {
      Swal.fire({
        title: "Are You Sure?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Delete Post!",
      }).then((result) => {
        if (result.value) {
          let url = `/delete-post`;

          axios.post(url, { id: id }).then((response) => {
            Toast.fire({
              type: "success",
              title: "Deleted!",
            });

            this.getPosts();
          });
        }
      });
    },
  },
};
</script>

<style>
</style>