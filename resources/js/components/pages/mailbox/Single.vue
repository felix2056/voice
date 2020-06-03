<template>
<div class="content-wrapper" style="min-height: 1643.5px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Single
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">{{ mail.subject }}</li>
      </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <div class="row">
  <div class="col-lg-12 col-12">
    <div class="box box-solid bg-dark">
      <div class="box-header no-border">
        <h3 class="box-title">Read Mail</h3>
        <div class="box-controls pull-right align-items-baseline">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm">
              <i class="fa fa-chevron-left"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm">
              <i class="fa fa-chevron-right"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="box-body bg-dark">
        <div class="mailbox-read-info py-0">
          <h3>{{ mail.subject }}</h3>
        </div>
        <div class="mailbox-read-info clearfix">
          <div class="left-float margin-r-5">
            <a href="#">
              <img :src="mail.sender.avatar_url" :alt="mail.sender.name" width="40" class="rounded-circle" />
            </a>
          </div>
          <h5 class="no-margin">
            {{ mail.sender.name }}
            <br />

            
            <small>From: {{ mail.sender.email }}</small>
            <span class="mailbox-read-time pull-right">
                <timeago :datetime="mail.created_at" :auto-update="60"></timeago>
            </span>
          </h5>
        </div>

        <div class="mailbox-controls with-border clearfix">
          <div class="left-float">
            <button
              type="button"
              class="btn btn-default btn-sm"
              data-toggle="tooltip"
              title
              data-original-title="Print"
            >
              <i class="fa fa-print"></i>
            </button>
          </div>
          <div class="right-float">
            <div class="btn-group">
              <button
                type="button"
                class="btn btn-default btn-sm"
                data-toggle="tooltip"
                data-container="body"
                title
                data-original-title="Delete"
              >
                <i class="fa fa-trash-o"></i>
              </button>
              <button
                type="button"
                class="btn btn-default btn-sm"
                data-toggle="tooltip"
                data-container="body"
                title
                data-original-title="Reply"
              >
                <i class="fa fa-reply"></i>
              </button>
              <button
                type="button"
                class="btn btn-default btn-sm"
                data-toggle="tooltip"
                data-container="body"
                title
                data-original-title="Forward"
              >
                <i class="fa fa-share"></i>
              </button>
            </div>
          </div>
          <!-- /.btn-group -->
        </div>

        <div class="mailbox-read-message">
          <p v-html="mail.body"></p>
        </div>

        <div class="p-15 bt-1">
          <h5>
            <i class="fa fa-paperclip m-r-10 m-b-10"></i> Attachments
            <span>(3)</span>
          </h5>
          <ul class="mailbox-attachments clearfix">
            <li>
              <div class="mailbox-attachment-info">
                <a href="#" class="mailbox-attachment-name">
                  <i class="fa fa-paperclip"></i> Mag.pdf
                </a>
                <span class="mailbox-attachment-size">
                  5,215 KB
                  <a href="#" class="btn btn-default btn-xs pull-right">
                    <i class="fa fa-cloud-download"></i>
                  </a>
                </span>
              </div>
            </li>
            <li>
              <div class="mailbox-attachment-info">
                <a href="#" class="mailbox-attachment-name">
                  <i class="fa fa-paperclip"></i> Documents.docx
                </a>
                <span class="mailbox-attachment-size">
                  2,145 KB
                  <a href="#" class="btn btn-default btn-xs pull-right">
                    <i class="fa fa-cloud-download"></i>
                  </a>
                </span>
              </div>
            </li>
            <li>
              <div class="mailbox-attachment-info">
                <a href="#" class="mailbox-attachment-name">
                  <i class="fa fa-camera"></i> Image.png
                </a>
                <span class="mailbox-attachment-size">
                  2.67 MB
                  <a href="#" class="btn btn-default btn-xs pull-right">
                    <i class="fa fa-cloud-download"></i>
                  </a>
                </span>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="box-footer bg-dark">
        <div class="pull-right">
          <button type="button" class="btn btn-success">
            <i class="fa fa-reply"></i> Reply
          </button>
          <button type="button" class="btn btn-info">
            <i class="fa fa-share"></i> Forward
          </button>
        </div>
        <button type="button" class="btn btn-danger">
          <i class="fa fa-trash-o"></i> Delete
        </button>
        <button type="button" class="btn btn-warning">
          <i class="fa fa-print"></i> Print
        </button>
      </div>
      <!-- /.box-footer -->
    </div>

    <!-- /. box -->
  </div>
      </div>
    </section>
</div>
</template>

<script>
export default {
  data() {
    return {
        loading: false,
        mail: []
    };
  },
  
  async created() {
    await this.getMail();
  },

  methods: {
    async getMail() {
      this.loading = true;

      //Fetch single pack
      let url = `/mail/${this.$route.params.slug}`;

      api
        .get(url)
        .then(response => {
          this.mail = response.data.mail;
          this.loading = false;
        })
        .catch(error => {
          console.log(error.response.data);
        });
    }
  },

  watch: {
    $route() {
      this.getMail();
    }
  },
};
</script>

<style>
</style>