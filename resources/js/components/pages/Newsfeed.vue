<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Newsfeed
      </h1>
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
                    <img class="avatar" :src="post.user.avatar_url" :alt="post.user.name">

                    <div class="media-body">
                      <p>
                        <strong>{{ post.user.name }}</strong>
                        <timeago class="float-right" :datetime="post.created_at" :auto-update="60"></timeago>
                      </p>
                      
                      <p v-html="post.headline"></p>
                      
                      <div v-if="$is('Admin') || post.user.id == user.id" class="media-block-actions">
                        <nav class="nav no-gutters gap-2 font-size-16 media-hover-show">
                          <a @click.prevent="deleteNews(post.id)" class="nav-link text-danger" href="#" data-toggle="tooltip" title="" data-original-title="Delete"><i class="ion-close"></i></a>
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

      posts: []
    };
  },

  async mounted() {
    await this.getPosts();
  },

  methods: {
    async getPosts() {
      this.loading = true;

      let url = `/posts`;

      axios.get(url).then(response => {
        this.posts = response.data.posts;
        this.loading = false;
      });
    },

    async deleteNews(id) {
      Swal.fire({
        title: "Are You Sure?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes Delete Post!"
      }).then(result => {
        if (result.value) {
          let url = `/delete-post`;

          axios.post(url, { id: id})
          .then(response => {
            Toast.fire({
              type: "success",
              title: "Deleted!"
            });

            this.getPosts();
          }); 
        }
      });
    }
  }
};
</script>

<style>

</style>