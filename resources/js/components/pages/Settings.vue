<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Settings</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Settings</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- vertical wizard -->
      <div class="box box-solid bg-dark">
        <div class="box-header with-border">
          <h3 class="box-title">Application Settings</h3>
          <h6
            class="box-subtitle"
          >configure and setup website data. All changes made on this form will be referenced on the entire website</h6>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove">
              <i class="fa fa-remove"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body wizard-content">
          <form @submit.prevent="updateSettings" class="tab-wizard vertical wizard-circle">
            <section class="bg-hexagons-dark">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstName1">Application Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="settings.site_name"
                      id="firstName1"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstName1">Application Short Name</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="settings.short_name"
                      id="lastName2"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <img
                    style="border: 2px solid white;height: 25vh;width: 60vh;"
                    :src="logoData !== null ? logoData : '/storage/site/' + settings.logo"
                  />

                  <div class="form-group">
                    <label for="emailAddress2">
                      Logo
                      <span class="text-danger">[230 X 50 max size and max 1MB]</span>
                    </label>
                    <input
                      type="file"
                      @change="previewLogo"
                      accept=".jpeg, .jpg, .png"
                      class="form-control"
                      id="emailAddress2"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <img
                      style="border: 2px solid white;height: 25vh;width: 25vh;"
                      :src="faviconData !== null ? faviconData : '/storage/site/' + settings.favicon"
                    />

                    <label for="phoneNumber2">
                      Favicon
                      <span class="text-danger">[only .png image][32 X 32 exact size and max 512KB]</span>
                    </label>
                    <input
                      type="file"
                      @change="previewFavicon"
                      accept=".jpeg, .jpg, .png"
                      class="form-control"
                      id="phoneNumber2"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="location2">Application Link</label>
                    <input
                      type="text"
                      v-model="settings.site_link"
                      class="form-control"
                      id="phoneNumber2"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="location2">Application Email</label>
                    <input
                      type="text"
                      v-model="settings.email"
                      class="form-control"
                      id="phoneNumber2"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="location2">Application Phone No</label>
                    <input
                      type="text"
                      v-model="settings.contact_phone"
                      class="form-control"
                      id="phoneNumber2"
                    />
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="location2">Application Address</label>
                    <input
                      type="text"
                      v-model="settings.contact_address"
                      class="form-control"
                      id="phoneNumber2"
                    />
                  </div>
                </div>
              </div>
            </section>
            <!-- Step 2 -->
            <h6>Application Description</h6>
            <section class="bg-hexagons-dark">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="jobTitle6">Job Title :</label>
                    <textarea
                      name="shortDescription"
                      v-model="settings.site_desc"
                      id="shortDescription2"
                      rows="6"
                      class="form-control"
                    ></textarea>
                  </div>
                </div>
              </div>
            </section>
            <!-- Step 3 -->
            <h6>Social</h6>
            <section class="bg-hexagons-dark">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="int2">Facebook</label>
                    <input type="text" v-model="settings.facebook" class="form-control" id="int2" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="int2">Twitter</label>
                    <input type="text" v-model="settings.twitter" class="form-control" id="int2" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="int2">Instagram</label>
                    <input type="text" v-model="settings.instagram" class="form-control" id="int2" />
                  </div>
                </div>
              </div>
            </section>
            <section>
              <div class="col-md-4 offset-md-4">
                <button type="submit" class="btn btn-block btn-success btn-lg">
                  {{ saving ? 'saving..' : 'save changes' }}
                  <span
                    v-if="saving"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                </button>
              </div>
            </section>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      user: Laravel.user,
      saving: false,

      settings: [],

      logoAttachment: null,
      faviconAttachment: null,

      logoData: null,
      faviconData: null
    };
  },

  computed: {
    disabled() {
      return this.saving;
    },

    isLogoReady() {
      return this.logoData !== null;
    },
    isFaviconReady() {
      return this.faviconData !== null;
    }
  },

  async mounted() {
    await this.getSettings();
  },

  methods: {
    async getSettings() {
      let url = `/settings`;

      axios.get(url).then(response => {
        this.settings = response.data.settings;
        this.loading = false;
      });
    },

    previewLogo: function(event) {
      let input = event.target;

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          this.logoData = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.logoAttachment = input.files[0];
      }
    },

    previewFavicon: function(event) {
      let input = event.target;

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          this.faviconData = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        this.faviconAttachment = input.files[0];
      }
    },

    async updateSettings() {
      this.saving = true;

      let url = `/settings`;

      let formData = new FormData();

      if (this.logoAttachment != null) {
        formData.append("logo", this.logoAttachment);
      }
      if (this.faviconAttachment != null) {
        formData.append("favicon", this.faviconAttachment);
      }

      formData.append("site_name", this.settings.site_name);
      formData.append("short_name", this.settings.short_name);
      formData.append("site_link", this.settings.site_link);
      formData.append("email", this.settings.email);
      formData.append("contact_phone", this.settings.contact_phone);
      formData.append("contact_address", this.settings.contact_address);

      formData.append("site_desc", this.settings.site_desc);

      formData.append("facebook", this.settings.facebook);
      formData.append("twitter", this.settings.twitter);
      formData.append("instagram", this.settings.instagram);

      formData.append("oldlogo", this.settings.logo);
      formData.append("oldfavicon", this.settings.favicon);

      let headers = { "Content-Type": "multipart/form-data" };

      axios
        .post(url, formData, { headers })
        .then(response => {
          this.logoAttachment = null;
          this.faviconAttachment = null;

          this.logoData = null;
          this.faviconData = null;

          this.getSettings();
        })
        .catch(error => {
          this.saving = false;

          error.response.data.error.site_name
            ? (this.errors.site_name = error.response.data.error.site_name)
            : (this.errors.site_name = "");
          error.response.data.error.short_name
            ? (this.errors.short_name = error.response.data.error.short_name)
            : (this.errors.short_name = "");
          error.response.data.error.site_link
            ? (this.errors.site_link = error.response.data.error.site_link)
            : (this.errors.site_link = "");
          error.response.data.error.email
            ? (this.errors.email = error.response.data.error.email)
            : (this.errors.email = "");
          error.response.data.error.contact_phone
            ? (this.errors.contact_phone =
                error.response.data.error.contact_phone)
            : (this.errors.contact_phone = "");
          error.response.data.error.contact_address
            ? (this.errors.contact_address =
                error.response.data.error.contact_address)
            : (this.errors.contact_address = "");
          error.response.data.error.site_desc
            ? (this.errors.site_desc = error.response.data.error.site_desc)
            : (this.errors.site_desc = "");

          error.response.data.error.facebook
            ? (this.errors.facebook = error.response.data.error.facebook)
            : (this.errors.facebook = "");
          error.response.data.error.twitter
            ? (this.errors.twitter = error.response.data.error.twitter)
            : (this.errors.twitter = "");
          error.response.data.error.instagram
            ? (this.errors.instagram = error.response.data.error.instagram)
            : (this.errors.instagram = "");
        });
    }
  }
};
</script>

<style>

</style>