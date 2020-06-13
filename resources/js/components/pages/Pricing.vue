<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Pricing & Plans</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Pricing & Plans</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content mt-40">
      <div class="row no-gutters">
        <div class="col-lg-4">
          <div class="box p-60 text-center pull-up">
            <h4 class="text-danger text-uppercase">Individual</h4>
            <br />
            <p>A simple option but powerful to manage your business.</p>
            <p>Email support</p>
            <br />
            <h3 class="price text-danger">
              <sup>$</sup>9
              <span>Monthly</span>
            </h3>

            <br />
            <a class="btn btn-bold btn-block btn-round btn-danger" href="#">Select Plan</a>
          </div>
        </div>

        <div class="col-lg-4">
          <div
            class="box box-shadowed box-round text-center bring-front py-80 px-60 pull-up"
            style="margin-top:-20px"
          >
            <h4 class="text-primary text-uppercase">Business</h4>
            <br />
            <p>Unlimited product including apps and more features.</p>
            <p>Mon-Fri support</p>
            <br />
            <h3 class="price text-primary">
              <sup>$</sup>39
              <span>Monthly</span>
            </h3>
            <br />
            <a class="btn btn-bold btn-block btn-round btn-primary" href="#">Select Plan</a>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="box p-60 text-center pull-up">
            <h4 class="text-info text-uppercase">Enterprise</h4>
            <br />
            <p>The best option for large scale companies.</p>
            <p>24/7 support</p>
            <br />
            <h3 class="price text-info">
              <sup>$</sup>89
              <span>Monthly</span>
            </h3>
            <br />
            <a class="btn btn-bold btn-block btn-round btn-info" href="#">Select Plan</a>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>