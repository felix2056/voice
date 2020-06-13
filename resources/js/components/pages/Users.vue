<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Users</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">
          Users
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="box">
            <div class="box-body">
              <div class="table-responsive">
                <table
                  id="example5"
                  class="table table-hover dataTable no-footer"
                  role="grid"
                  aria-describedby="example5_info"
                >
                  <thead class="d-none">
                    <tr role="row">
                      <th
                        class="sorting_asc"
                        tabindex="0"
                        aria-controls="example5"
                        rowspan="1"
                        colspan="1"
                        aria-sort="ascending"
                        aria-label="&amp;nbsp;: activate to sort column descending"
                      >&nbsp;</th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="example5"
                        rowspan="1"
                        colspan="1"
                        aria-label="&amp;nbsp;: activate to sort column ascending"
                      >&nbsp;</th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="example5"
                        rowspan="1"
                        colspan="1"
                        aria-label="&amp;nbsp;: activate to sort column ascending"
                      >&nbsp;</th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="example5"
                        rowspan="1"
                        colspan="1"
                        aria-label="&amp;nbsp;: activate to sort column ascending"
                      >&nbsp;</th>
                      <th
                        class="sorting"
                        tabindex="0"
                        aria-controls="example5"
                        rowspan="1"
                        colspan="1"
                        aria-label="&amp;nbsp;: activate to sort column ascending"
                      >&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr role="row" class="odd" v-for="member in members" :key="member.id">
                      <td class="w-20 sorting_1">
                        <i class="fa fa-square-o pt-15"></i>
                      </td>
                      <td class="w-20">
                        <i class="fa fa-star text-yellow pt-15"></i>
                      </td>
                      <td class="w-60">
                        <router-link
                          :to="{ name: 'Profile', params: { slug: member.slug  } }"
                          class="avatar avatar-lg status-success"
                        >
                          <img :src="member.avatar_url" :alt="member.name" />
                        </router-link>
                      </td>
                      <td class="w-300">
                        <p class="mb-0">
                          <router-link :to="{ name: 'Profile', params: { slug: member.slug  } }">
                            <strong>{{ member.name }}</strong>
                          </router-link>
                          <small class="sidetitle">{{ member.email }}</small>
                        </p>
                        <p class="mb-0">{{ member.roles[0].name }}</p>
                      </td>
                      <td>
                        <nav class="nav mt-2">
                          <a class="nav-link" href="#">
                            <i class="fa fa-facebook"></i>
                          </a>
                          <a class="nav-link" href="#">
                            <i class="fa fa-twitter"></i>
                          </a>
                          <a class="nav-link" href="#">
                            <i class="fa fa-github"></i>
                          </a>
                          <a class="nav-link" href="#">
                            <i class="fa fa-linkedin"></i>
                          </a>
                        </nav>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
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

        console.log(this.members.admins[0].name);
      });
    }
  }
};
</script>

<style>
</style>