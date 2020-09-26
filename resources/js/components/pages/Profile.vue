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
                <!-- <img
                v-if="profile.id == user.id"
                class="profile-user-img rounded-circle img-fluid mx-auto d-block"
                :src="avatar_image"
                :alt="profile.name"
              /> -->

              <img
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

              <!-- <p class="text-center">{{ profile.roles[0].name }}</p> -->

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

                    <!-- <div v-if="profile.id != user.id" class="user-social-acount">
                      <router-link
                        :to="{ name: 'Chat', params: { slug: profile.slug  } }"
                        class="btn btn-block btn-social btn-foursquare"
                      >
                        <i class="fa fa-comments-o"></i> Send Message
                      </router-link>
                    </div> -->
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

                     <div class="form-group row" :class="{ 'has-error': errors.postalcode != '' }">
                      <label class="col-sm-2 col-form-label">Bio</label>
                      <div v-if="user.id == profile.id" class="col-sm-10">
                        <textarea class="form-control" v-model="profile.bio" cols="30" rows="10"></textarea>
                        
                        <label
                          v-if="errors.bio != ''"
                          class="control-label"
                          for="inputError"
                        >
                          <i class="fa fa-times-circle-o"></i>
                          {{ String(errors.bio) }}
                        </label>
                      </div>
                      <div v-else class="col-sm-10">
                        <label class="col-sm-6 col-form-label">{{ profile.bio }}</label>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>

                <div class="row">
                  <div class="col-12">
                    <div v-if="user.id == profile.id" class="form-group row">
                      <label class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-yellow">
                          <i v-if="saving" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                          {{ saving ? 'Saving..' : 'Save Changes' }}
                        </button>
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

      saving: false,

      errors: {
        name: "",
        email: "",
        phonenumber: "",
        street: "",
        city: "",
        state: "",
        postalcode: "",
        bio: ""
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
      return this.avatarData == null ? this.profile.avatar_url : this.avatarData;
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

      this.saving = true;

      let data = [];

      formData.append("name", this.profile.name);
      formData.append("email", this.profile.email);
      formData.append("phonenumber", this.profile.phonenumber);
      formData.append("street", this.profile.street);
      formData.append("city", this.profile.city);
      formData.append("state", this.profile.state);
      formData.append("postalcode", this.profile.postalcode);
      formData.append("bio", this.profile.bio);

      let headers = { "Content-Type": "multipart/form-data" };

      axios
        .post(url, formData, { headers })
        .then(() => {
          this.saving = false;

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