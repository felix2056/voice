<template>
  <div class="content-wrapper" style="min-height: 1748.5px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Compose</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Compose</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="box box-solid bg-dark">
            <div class="box-header no-border">
              <h3 class="box-title">Compose New Message</h3>
            </div>

            <form @submit.prevent="sendMail">
              <div class="box-body bg-dark">
                <div class="form-group" :class="{ 'has-error': errors.to != '' }">
                  <input class="form-control" v-model="input.to" placeholder="To:" />
                  <label v-if="errors.to != ''" class="control-label" for="inputError">
                    <i class="fa fa-times-circle-o"></i> {{ String(errors.to) }}
                  </label>
                </div>
                <div class="form-group" :class="{ 'has-error': errors.subject != '' }">
                  <input class="form-control" v-model="input.subject" placeholder="Subject:" />
                  <label v-if="errors.subject != ''" class="control-label" for="inputError">
                    <i class="fa fa-times-circle-o"></i> {{ String(errors.subject) }}
                  </label>
                </div>
                <div class="form-group" :class="{ 'has-error': errors.body != '' }">
                  <editor
                    api-key="89wibrodin74xxczxdk9eqmk20bhmmhphl3gh2dj3owgi3fo"
                    v-model="input.body"
                    :init="{
                                height: 300,
                                menubar: false,
                                plugins: [
                                'advlist autolink lists link image charmap print preview anchor',
                                'searchreplace visualblocks code fullscreen',
                                'insertdatetime media table paste code help wordcount'
                                ],
                                mediaembed_max_width: 450,
                                content_style: 'body { font-family: Arial; background: #252525; color: white; font-size: 14pt; }',
                                toolbar:
                                'undo redo | formatselect | bold italic backcolor | \
                                alignleft aligncenter alignright alignjustify | \
                                bullist numlist outdent indent | removeformat | help'
                            }"
                  />
                  <label v-if="errors.body != ''" class="control-label" for="inputError">
                    <i class="fa fa-times-circle-o"></i> {{ String(errors.body) }}
                  </label>
                </div>
                <div class="form-group">
                  <div class="btn btn-info btn-file">
                    <i class="fa fa-paperclip"></i> Attachment
                    <input type="file" name="attachment" />
                  </div>
                  <p class="help-block">Max. 32MB</p>
                </div>
              </div>
              <div class="box-footer bg-dark">
                <div class="pull-right">
                  <button type="button" class="btn btn-default">
                    <i class="fa fa-pencil"></i> Draft
                  </button>
                  <button type="submit" :disabled="disabled" class="btn btn-success">
                    <i class="fa fa-envelope-o"></i>
                    {{ sending ? 'Sending..' : 'Send' }}
                  </button>
                </div>
                <button type="reset" class="btn btn-danger">
                  <i class="fa fa-times"></i> Discard
                </button>
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
      sending: false,

      input: {
        to: "",
        subject: "",
        body: ""
      },

      errors: {
        to: "",
        subject: "",
        body: ""
      }
    };
  },

  computed: {
    disabled() {
      return this.sending == true
    }
  },

  methods: {
    sendMail() {
      if (!this.user) {
        return;
      }

      if (this.input.to == "") {
        return;
      } else if (this.input.subject == "") {
        return;
      } else if (this.input.body == "") {
        return;
      }

      this.sending = true;

      let to = this.input.to;
      let subject = this.input.subject;
      let body = this.input.body;

      let url = `/send-mail`;

      axios
        .post(url, { to: to, subject: subject, body: body })
        .then(response => {
          this.sending = false;

          this.input.to = "";
          this.input.subject = "";
          this.input.body = "";
        })
        .catch(error => {
          this.sending = false;

          error.response.data.error.to
            ? (this.errors.to = error.response.data.error.to)
            : (this.errors.to = "");
          error.response.data.error.subject
            ? (this.errors.subject = error.response.data.error.subject)
            : (this.errors.subject = "");
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