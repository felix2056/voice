<template>
  <div class="content-wrapper" style="min-height: 1993.5px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Billing
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <router-link :to="{ name: 'Home' }">
                <i class="fa fa-dashboard"></i> Home
            </router-link>
        </li>
        <li class="breadcrumb-item">
            <router-link :to="{ name: 'Billing' }">Billing</router-link>
        </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
     <!-- Basic Forms -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Billing Information</h3>
          <h6 class="box-subtitle">update your billing information</h6>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <section class="bg-hexagons-dark body current" id="steps-uid-1-p-0" role="tabpanel" aria-labelledby="steps-uid-1-h-0" aria-hidden="false">
					<div class="row">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="fullname">Full Name :</label>
								<input type="text" class="form-control" id="fullname" v-model="user.name"></div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Email :</label>
								<input type="text" class="form-control" disabled id="email" v-model="user.email"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="address">Address 1 :</label>
								<input type="text" class="form-control" id="address"> </div>
						</div>

                        <div class="col-md-6">
							<div class="form-group">
								<label for="address2">Address 2 (optional) :</label>
								<input type="text" class="form-control" id="address2"> </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="location3">Select City :</label>
								<select class="custom-select form-control" id="location3" name="location">
									<option value="">Select City</option>
									<option value="Amsterdam">India</option>
									<option value="Berlin">USA</option>
									<option value="Frankfurt">Dubai</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="postal">Postal Code :</label>
								<input type="text" class="form-control" id="postal"> </div>
						</div>
					</div>
                    <button type="button" class="btn btn-block btn-success">save</button>
				</section>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
    data() {
        return {
            user: Laravel.user
        }
    }
}
</script>

<style>

</style>