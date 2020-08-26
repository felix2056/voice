<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Members Profile</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Members' }">Members</router-link>
        </li>
        <li class="breadcrumb-item active">{{ profile.name }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xl-4 col-lg-5">
          <!-- Profile Image -->
          <div class="box bg-inverse bg-dark bg-hexagons-white">
            <div class="box-body box-profile">
                <img
                v-if="profile.id == user.id"
                class="profile-user-img rounded-circle img-fluid mx-auto d-block"
                :src="avatar_image"
                :alt="profile.name"
              />

              <img
                v-else
                class="profile-user-img rounded-circle img-fluid mx-auto d-block"
                :src="avatar_image"
                :alt="profile.name"
              />

              <input
                type="file"
                @change="previewAvatar"
                ref="avatar"
                accept=".jpeg, .jpg, .png, .gif"
                style="display: none"
            />

              <h3 class="profile-username text-center">{{ profile.name }}</h3>

              <p class="text-center">{{ profile.roles[0].name }}</p>

              <div v-if="profile.id == user.id" class="row social-states">
                <div class="col-12 text-center">
                  <button @click="pickAvatar" class="btn btn-block btn-social btn-linkedin">
                    <i class="ion ion-image"></i> change avatar
                  </button>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="profile-user-info">
                    <p>
                      <i class="fa fa-envelope pr-15"></i>
                      {{ profile.email }}
                    </p>
                    <p>
                      <i class="fa fa-phone pr-15"></i>
                      {{ profile.phonenumber }}
                    </p>
                    <p>
                      <i class="fa fa-map-marker pr-15"></i>
                      {{ profile.street }}
                    </p>

                    <div v-if="profile.id != user.id" class="user-social-acount">
                      <router-link
                        :to="{ name: 'Chat', params: { slug: profile.slug  } }"
                        class="btn btn-block btn-social btn-foursquare"
                      >
                        <i class="fa fa-comments-o"></i> Send Message
                      </router-link>
                    </div>

                    <p class="mt-25">Social Profile</p>
                    <div class="user-social-acount">
                      <button class="btn btn-block btn-social btn-facebook">
                        <i class="fa fa-facebook"></i> Facebook
                      </button>
                      <button class="btn btn-block btn-social btn-twitter">
                        <i class="fa fa-twitter"></i> Twitter
                      </button>
                      <button class="btn btn-block btn-social btn-instagram">
                        <i class="fa fa-instagram"></i> Instagram
                      </button>
                      <button class="btn btn-block btn-social btn-linkedin">
                        <i class="fa fa-linkedin"></i> Linkedin
                      </button>
                    </div>
                    <div class="map-box mt-25 mb-0">
                      <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2805244.1745767146!2d-86.32675167439648!3d29.383165774894163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88c1766591562abf%3A0xf72e13d35bc74ed0!2sFlorida%2C+USA!5e0!3m2!1sen!2sin!4v1501665415329"
                        height="150"
                        class="w-p100 b-0"
                        allowfullscreen
                      ></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-8 col-lg-7">
          <div class="box box-solid bg-black">
            <div class="box-header with-border">
              <h3 class="box-title">Personal details</h3>
            </div>
            <!-- /.box-header -->
            <form
              enctype="multipart/form-data"
              accept-charset="UTF-8"
              method="post"
              @submit.prevent="updateUser"
            >
              <div class="box-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row" :class="{ 'has-error': errors.name != '' }">
                      <label class="col-sm-2 col-form-label">Full Name</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.name"
                          placeholder="Johon"
                        />
                        <label v-if="errors.name != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.name) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.name }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.email != '' }">
                      <label class="col-sm-2 col-form-label">Email Adress</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="email"
                          v-model="profile.email"
                          disabled
                          placeholder="johone@dummy.com"
                        />
                        <label v-if="errors.email != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.email) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.email }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.phonenumber != '' }">
                      <label class="col-sm-2 col-form-label">Phone</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="tel"
                          v-model="profile.phonenumber"
                          placeholder="123 456 7890"
                        />
                        <label
                          v-if="errors.phonenumber != ''"
                          class="control-label"
                          for="inputError"
                        >
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.phonenumber) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.phonenumber }}</label>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="form-group row" :class="{ 'has-error': errors.street != '' }">
                      <label class="col-sm-2 col-form-label">Street</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.street"
                          placeholder="A-458, Lorem Ipsum, city"
                        />
                        <label v-if="errors.street != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.street) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.street }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.city != '' }">
                      <label class="col-sm-2 col-form-label">City</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.city"
                          placeholder="Your City"
                        />
                        <label v-if="errors.city != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.city) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.city }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.state != '' }">
                      <label class="col-sm-2 col-form-label">State</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.state"
                          placeholder="Your State"
                        />
                        <label v-if="errors.state != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.state) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.state }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.postalcode != '' }">
                      <label class="col-sm-2 col-form-label">Post Code</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="number"
                          v-model="profile.postalcode"
                          placeholder="123456"
                        />
                        <label
                          v-if="errors.postalcode != ''"
                          class="control-label"
                          for="inputError"
                        >
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.postalcode) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.postalcode }}</label>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="row">
                  <div class="col-12">
                    <div class="form-group row" :class="{ 'has-error': errors.facebook != '' }">
                      <label class="col-sm-2 col-form-label">Facebook</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.facebook"
                          placeholder="facebook id"
                        />
                        <label v-if="errors.facebook != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.facebook) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.facebook }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.instagram != '' }">
                      <label class="col-sm-2 col-form-label">Instagram</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.instagram"
                          placeholder="instagram id"
                        />
                        <label v-if="errors.instagram != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.instagram) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.instagram }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.twitter != '' }">
                      <label class="col-sm-2 col-form-label">Twitter</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.twitter"
                          placeholder="twitter id"
                        />
                        <label v-if="errors.twitter != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.twitter) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.twitter }}</label>
                      </div>
                    </div>

                    <div class="form-group row" :class="{ 'has-error': errors.linkedin != '' }">
                      <label class="col-sm-2 col-form-label">Linkedin</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <input
                          class="form-control"
                          type="text"
                          v-model="profile.linkedin"
                          placeholder="linkedin id"
                        />
                        <label v-if="errors.linkedin != ''" class="control-label" for="inputError">
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.linkedin) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.linkedin }}</label>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Toggle social visibility</label>

                      <div class="col-sm-10">
                        <input type="checkbox" name="toggleSocial" id />
                      </div>
                    </div>

                    <div v-if="user.id == profile.id" class="form-group row">
                      <label class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-yellow">Submit</button>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
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
export default {
  data() {
    return {
      user: Laravel.user,
      profile: [],

      avatarAttachment: null,
      avatarData: null,

      errors: {
        name: "",
        email: "",
        phonenumber: "",
        street: "",
        city: "",
        state: "",
        postalcode: "",

        facebook: "",
        instagram: "",
        twitter: "",
        linkedin: "",
      },
    };
  },

  computed: {
    disabled() {
      return this.saving;
    },

    isAvatarReady() {
      return this.avatarData !== null;
    },

    avatar_image() {
      return this.avatarData == null ? this.user.avatar_url : this.avatarData;
    }
  },

  async created() {
    await this.getProfile();
  },

  methods: {
    pickAvatar() {
      this.$refs.avatar.click();
    },

    previewAvatar: function(event) {
      let input = event.target;

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          this.avatarData = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
        this.avatarAttachment = input.files[0];
      }
    },

    async getProfile() {
      this.loading = true;

      //Fetch single profile
      let url = `/profile/${this.$route.params.slug}`;

      api
        .get(url)
        .then((response) => {
          this.profile = response.data.profile;
          this.loading = false;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },

    async updateUser() {
      let url = `/update-user`;

      let formData = new FormData();

      if (this.avatarAttachment != null) {
        formData.append("avatar", this.avatarAttachment);
      }

      let data = [];

      formData.append("name", this.profile.name);
      formData.append("email", this.profile.email);
      formData.append("phonenumber", this.profile.phonenumber);
      formData.append("street", this.profile.street);
      formData.append("city", this.profile.city);
      formData.append("state", this.profile.state);
      formData.append("postalcode", this.profile.postalcode);
      
      formData.append("facebook", this.profile.facebook);
      formData.append("instagram", this.profile.instagram);
      formData.append("twitter", this.profile.twitter);
      formData.append("linkedin", this.profile.linkedin);

      let headers = { "Content-Type": "multipart/form-data" };

      axios
        .post(url, formData, { headers })
        .then(() => {
            Toast.fire({
                type: "success",
                title: "Successfully updated profile!"
            });
        })
        .catch((error) => {
          this.saving = false;
          error.response.data.error.name
            ? (this.errors.name = error.response.data.error.name)
            : (this.errors.name = "");
          error.response.data.error.email
            ? (this.errors.email = error.response.data.error.email)
            : (this.errors.email = "");
          error.response.data.error.phonenumber
            ? (this.errors.phonenumber = error.response.data.error.phonenumber)
            : (this.errors.phonenumber = "");
          error.response.data.error.street
            ? (this.errors.street = error.response.data.error.street)
            : (this.errors.street = "");
          error.response.data.error.city
            ? (this.errors.city = error.response.data.error.city)
            : (this.errors.city = "");
          error.response.data.error.state
            ? (this.errors.state = error.response.data.error.state)
            : (this.errors.state = "");
          error.response.data.error.postalcode
            ? (this.errors.postalcode = error.response.data.error.postalcode)
            : (this.errors.postalcode = "");

          error.response.data.error.facebook
            ? (this.errors.facebook = error.response.data.error.facebook)
            : (this.errors.facebook = "");
          error.response.data.error.instagram
            ? (this.errors.instagram = error.response.data.error.instagram)
            : (this.errors.instagram = "");
          error.response.data.error.instagram
            ? (this.errors.twitter = error.response.data.error.twitter)
            : (this.errors.twitter = "");
          error.response.data.error.linkedin
            ? (this.errors.linkedin = error.response.data.error.linkedin)
            : (this.errors.linkedin = "");
        });
    },
  },
};
</script>

<style>
</style>