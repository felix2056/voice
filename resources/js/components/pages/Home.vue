<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box box-inverse box-dark">
            <div class="box-body tickers-block">
              <div class="tickercontainer" style="height: auto; overflow: hidden;">
                <div class="mask">
                  <ul
                    id="webticker-1"
                    style="position: relative; overflow: hidden; float: left; font: bold 10px Verdana; list-style-type: none; margin: 0px; padding: 0px; width: 1766.39px; transition-timing-function: linear; transition-duration: 3.40218s; left: -170.109px;"
                  >
                    <!-- <li v-for="post in posts" :key="post.id" style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i> {{ post.headline }}
                    </li> -->
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                    <li style="white-space: nowrap; float: left; padding: 0px 7px;">
                      <i class="cc GAME"></i>post.headline
                    </li>
                  </ul>
                  <span class="tickeroverlay-left" style="display: none;">&nbsp;</span>
                  <span class="tickeroverlay-right" style="display: none;">&nbsp;</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-20">
        <div class="col-xl-3 col-md-6 col-6">
          <!-- small box -->
          <div class="small-box bg-info pull-up bg-hexagons-white">
            <div class="inner">
              <h3>{{ statistics['totalPosts'] }}</h3>

              <p>New Headlines</p>
            </div>
            <div class="icon">
              <i class="fa fa-newspaper-o"></i>
            </div>
            
            <router-link :to="{ name: 'Newsfeed' }" class="small-box-footer">
              More info <i class="fa fa-arrow-right"></i>
            </router-link>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-6">
          <div class="small-box bg-success pull-up bg-hexagons-white">
            <div class="inner">
              <h3>{{ statistics['totalBroadcasters'] }}</h3>

              <p>Broadcasters</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <router-link :to="{ name: 'Members' }" class="small-box-footer">More info <i class="fa fa-arrow-right"></i></router-link>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-6">
          <div class="small-box bg-primary pull-up bg-hexagons-white">
            <div class="inner">
              <h3>{{ statistics['totalWriters'] }}</h3>

              <p>Writers</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <router-link :to="{ name: 'Members' }" class="small-box-footer">More info <i class="fa fa-arrow-right"></i></router-link>
          </div>
        </div>

        <div class="col-xl-3 col-md-6 col-6">
          <div class="small-box bg-danger pull-up bg-hexagons-white">
            <div class="inner">
              <h3>{{ statistics['totalViewers'] }}</h3>

              <p>Viewers</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <router-link :to="{ name: 'Members' }" class="small-box-footer">More info <i class="fa fa-arrow-right"></i></router-link>
          </div>
        </div>
      </div>

      <div class="row mt-20">
        <div class="col-12">
            <h4 class="page-header">User Header</h4>
        </div>
        <div class="col-12">
            <div class="box box-inverse bg-img" style="background-image: url(/images/gallery/full/1.jpg);" data-overlay="2">
              <div class="flexbox px-20 pt-20">
                <label class="toggler toggler-danger text-white">
                  <input type="checkbox">
                  <i class="fa fa-heart"></i>
                </label>
                <div class="dropdown">
                  <a data-toggle="dropdown" href="#"><i class="ti-more-alt rotate-90 text-white"></i></a>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-picture-o"></i> Shots</a>
                    <a class="dropdown-item" href="#"><i class="ti-check"></i> Follow</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fa fa-ban"></i> Block</a>
                  </div>
                </div>
              </div>

              <div class="box-body text-center pb-50">
                <router-link :to="{ name: 'Profile', params: { slug: user.slug  } }">
                  <img class="avatar avatar-xxl avatar-bordered" :src="user.avatar_url" :alt="user.name">
                </router-link>
                <h4 class="mt-2 mb-0">
                  <router-link :to="{ name: 'Profile', params: { slug: user.slug  } }" class="hover-primary text-white">
                    {{ user.name }}
                  </router-link>
                </h4>
                <span><i class="fa fa-map-marker w-20"></i> {{ user.country }}</span>
              </div>

              <ul class="box-body flexbox flex-justified text-center" data-overlay="4">
                <li>
                  <span class="opacity-60">Followers</span><br>
                  <span class="font-size-20">8.6K</span>
                </li>
                <li>
                  <span class="opacity-60">Following</span><br>
                  <span class="font-size-20">8457</span>
                </li>
                <li>
                  <span class="opacity-60">Tweets</span><br>
                  <span class="font-size-20">2154</span>
                </li>
              </ul>
            </div>
          </div>
      </div>

      <div class="row mt-20">
        <div class="col-12">
            <h4 class="page-header">New Members</h4>
        </div>
        <div v-for="profile in profiles" :key="profile.id" class="col-md-6 col-lg-4">
            <div class="box">

              <div class="text-white box-body bg-img text-center py-50" style="background-image: url(/images/gallery/thumb/10.jpg);">
                <router-link :to="{ name: 'Profile', params: { slug: profile.slug  } }">
                  <img class="avatar avatar-xxl avatar-bordered" :src="profile.avatar_url" :alt="profile.name">
                </router-link>

                <h5 class="mt-2 mb-0">
                  <router-link :to="{ name: 'Profile', params: { slug: profile.slug  } }" class="text-white">
                  {{ profile.name }}
                  </router-link>
                </h5>

                <span>{{ profile.roles[0].name }}</span>
              </div>
              <ul class="flexbox flex-justified text-center p-20">
                <li class="br-1 border-light">
                  <span class="text-muted">Followers</span><br>
                  <span class="font-size-20">6.6K</span>
                </li>
                <li class="br-1 border-light">
                  <span class="text-muted">Following</span><br>
                  <span class="font-size-20">5148</span>
                </li>
                <li>
                  <span class="text-muted">Tweets</span><br>
                  <span class="font-size-20">2154</span>
                </li>
              </ul>
            </div>
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>

<script>
export default {
  data() {
    return {
      user: Laravel.user,
      loading: false,

      statistics: [],
      posts: [],
      profiles: []
    };
  },

  async mounted() {
    await this.getStats();
    await this.getPosts();
    await this.getProfiles();
  },

  methods: {
    async getStats() {
      let url = `/home-statistics`;

      api.get(url).then(response => {
        this.statistics = response.data.statistics;
      });
    },

    async getPosts() {
      this.loading = true;

      let url = `/posts`;

      api.get(url).then(response => {
        this.posts = response.data.posts;
        this.loading = false;
      });
    },

    async getProfiles() {
      this.loading = true;

      let url = `/recent-profiles`;

      api.get(url).then(response => {
        this.profiles = response.data.profiles;
        this.loading = false;
      });
    },
  }
};
</script>

<style>
</style>