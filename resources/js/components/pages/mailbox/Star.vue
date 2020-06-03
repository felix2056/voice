<template>
  <div class="box">
			  <div class="box-header bg-dark no-border">
				<h3 class="box-title">Starred</h3>
				  <div class="box-controls pull-right align-items-baseline">	
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					  </div>					  				
					  <h5 class="mb-0 pr-10">1-50/200</h5>
				  </div>
				  
				  <div class="mailbox-controls px-0 pb-0">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="ion ion-android-checkbox-outline-blank"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-trash-a"></i></button>
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-reply"></i></button>
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-share"></i></button>
					</div>
					<!-- /.btn-group -->
					<div class="btn-group">
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  <i class="ion ion-flag margin-r-5"></i>
						  <span class="caret"></span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					  </div>
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  <i class="ion ion-folder margin-r-5"></i>
						  <span class="caret"></span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					  </div>
					</div>
					<!-- /.btn-group -->
					<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
					  
					<div class="lookup lookup-lg lookup-right pull-right">
					  <input type="text" name="s">
					</div>
				  </div>
			  </div>

			  <div class="box-body">				
				<div class="mailbox-messages">
					<div class="table-responsive">
						<table class="table table-hover b-2">
						  <tbody>
                            <tr v-for="mail in mails" :key="mail.id">
								<router-link :to="{ name: 'Single', params: { slug: mail.slug  } }">
                                <td>
                                    <div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                        <input type="checkbox" style="position: absolute; opacity: 0;">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div>
                                </td>
                                
                                <td class="mailbox-star">
                                    <router-link :to="{ name: 'Single', params: { slug: mail.slug  } }">
                                        <i class="fa fa-star-o text-yellow"></i>
                                    </router-link>
                                </td>
                                
                                <td class="mailbox-name">{{ mail.sender.name }}</td>
                                
                                <td class="mailbox-subject">
                                    <a href="read-mail.html">
                                        <b>{{ mail.subject }}</b>
                                    </a>
                                </td>

                                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                                <td class="mailbox-date"><timeago :datetime="mail.created_at" :auto-update="60"></timeago></td>
								</router-link>
							</tr>
						  </tbody>
						</table>
					<!-- /.table -->
					</div>
				  </div>
			  </div>			  
				<div class="box-footer no-padding bg-dark">
				  <div class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="ion ion-android-checkbox-outline-blank"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-trash-a"></i></button>
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-reply"></i></button>
					  <button type="button" class="btn btn-default btn-sm"><i class="ion ion-share"></i></button>
					</div>
					<!-- /.btn-group -->
					<div class="btn-group">
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  <i class="ion ion-flag margin-r-5"></i>
						  <span class="caret"></span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					  </div>
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						  <i class="ion ion-folder margin-r-5"></i>
						  <span class="caret"></span>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					  </div>
					</div>
					<!-- /.btn-group -->
					<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
					<div class="pull-right">
					  1-50/200
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					  </div>
					  <!-- /.btn-group -->
					</div>
					<!-- /.pull-right -->
				  </div>
				</div>
			</div> 
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            mails: []
        }
    },

    async created() {
        await this.getMails();
    },

    methods: {
        async getMails() {
            this.loading = true;

            let url = `/mails-starred`;

            axios.get(url).then(response => {
                this.mails = response.data.mails;
                this.loading = false;
            });
        }
    }
}
</script>

<style>

</style>