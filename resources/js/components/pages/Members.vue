<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Members</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">
          <router-link :to="{ name: 'Members' }">Members</router-link>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div v-for="member in members" :key="member.id" class="col-6 col-md-6 col-lg-4 col-xl-3">
          <div class="box box-body pull-up">
            <div class="flexbox align-items-center">
              <label class="toggler toggler-yellow">
                <input type="checkbox" checked />
                <i class="fa fa-star"></i>
              </label>
              <div class="dropdown">
                <a data-toggle="dropdown" href="#" aria-expanded="false">
                  <i class="ion-android-more-vertical"></i>
                </a>
                <div
                  class="dropdown-menu dropdown-menu-right"
                  x-placement="bottom-end"
                  style="position: absolute; transform: translate3d(-138px, 20px, 0px); top: 0px; left: 0px; will-change: transform;"
                >
                  <router-link :to="{ name: 'Profile', params: { slug: member.slug  } }" class="dropdown-item">
                    <i class="fa fa-fw fa-user"></i> Profile
                  </router-link>

                  <div class="dropdown-divider"></div>

                  <router-link :to="{ name: 'Chat', params: { slug: member.slug  } }" class="dropdown-item">
                    <i class="fa fa-fw fa-comments"></i> Chat
                  </router-link>
                  
                  <!-- <a class="dropdown-item" href="#">
                    <i class="fa fa-fw fa-phone"></i> Call
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">
                    <i class="fa fa-fw fa-remove"></i> Remove
                  </a> -->
                </div>
              </div>
            </div>
            <div class="pt-3">
              <router-link :to="{ name: 'Profile', params: { slug: member.slug  } }">
                <Skeleton height="200px" :duration="20" v-if="!member.avatar_url" />

                <img class="rounded my-10" :src="member.avatar_url" :alt="member.name" />
              </router-link>
              <h3 class="m-0">
                <router-link
                  :to="{ name: 'Profile', params: { slug: member.slug  } }"
                >
                  <Skeleton>{{ member.name }}</Skeleton>
                </router-link>
              </h3>
              <span>{{ member.roles[0].name }}</span>
              <div class="bt-1 py-10 mt-10">
                <p
                  class="mb-0"
                >
                  <Skeleton> {{ 'Nemo enim ipsam voluptates consequr dolor amet quia aut fu magni dolor.' }}</Skeleton>
                </p>
              </div>
              <div class="mt-1">
                <a
                  target="_blank"
                  href="#"
                  class="btn btn-social-icon btn-rounded btn-facebook btn-outline"
                >
                  <i class="fa fa-facebook"></i>
                </a>
                <a
                  target="_blank"
                  href="#"
                  class="btn btn-social-icon btn-rounded btn-twitter btn-outline"
                >
                  <i class="fa fa-twitter"></i>
                </a>
                <a
                  target="_blank"
                  href="#"
                  class="btn btn-social-icon btn-rounded btn-instagram btn-outline"
                >
                  <i class="fa fa-instagram"></i>
                </a>
                <a
                  target="_blank"
                  href="#"
                  class="btn btn-social-icon btn-rounded btn-vimeo btn-outline"
                >
                  <i class="fa fa-linkedin"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <nav>
        <ul class="pagination justify-content-center">
          <li class="page-item disabled">
            <a class="page-link" href="#">
              <span class="ion-ios-arrow-thin-left"></span>
            </a>
          </li>
          <li class="page-item active">
            <a class="page-link" href="#">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">4</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">5</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="#">
              <span class="ion-ios-arrow-thin-right"></span>
            </a>
          </li>
        </ul>
      </nav>
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
import { Skeleton, SkeletonTheme } from 'vue-loading-skeleton';

export default {
  components: {
    Skeleton
  },

  data() {
    return {
      user: Laravel.user,

      loading: false,

      members: []
    };
  },

  async mounted() {
    await this.getMembers();
  },

  methods: {
    async getMembers() {
      this.loading = true;

      let url = `/members`;

      api.get(url).then(response => {
        this.members = response.data.viewers;
        this.loading = false;
      });
    }
  }
};
</script>

<style>
</style>