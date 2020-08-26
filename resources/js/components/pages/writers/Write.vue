<template>
  <div class="content-wrapper" style="min-height: 644px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Write News</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Write</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="box box-solid bg-dark">
            <div class="box-header no-border">
              <h3 class="box-title">Write New Post</h3>
            </div>

            <form @submit.prevent="createPost">
              <div class="box-body bg-dark">
                <div class="form-group">
                  <input class="form-control" v-model="input.headline" placeholder="Headline" />
                  <span class="text-danger">{{ String(errors.headline) }}</span>
                </div>
              </div>
              <div class="box-footer bg-dark">
                <div class="pull-right">
                  <button type="submit" :disabled="disabled" class="btn btn-success">
                    <i class="fa fa-envelope-o"></i>
                    {{ posting ? 'Posting..' : 'Post' }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";

export default {
  components: {
    editor: Editor
  },

  data() {
    return {
      user: Laravel.user,
      posting: false,

      input: {
        headline: "",
        body: ""
      },

      errors: {
        headline: "",
        body: ""
      }
    };
  },

  computed: {
    disabled() {
      return this.posting == true
    }
  },

  methods: {
    createPost() {
      if (!this.user) {
        return;
      }

      if (this.input.headline == "") {
        return;
      } else if (this.input.body == "") {
        return;
      }

      this.posting = true;

      let headline = this.input.headline;
      let body = this.input.body;

      let url = `/create-post`;

      axios
        .post(url, { headline: headline, body: body })
        .then(response => {
          this.posting = false;

          this.input.headline = "";
          this.input.body = "";
        })
        .catch(error => {
          this.posting = false;
          
          error.response.data.error.headline
            ? (this.errors.headline = error.response.data.error.headline)
            : (this.errors.headline = "");
          error.response.data.error.body
            ? (this.errors.body = error.response.data.error.body)
            : (this.errors.body = "");
        });
    }
  }
};
</script>

<style>
</style>