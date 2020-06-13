<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Inbox
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <router-link :to="{ name: 'Home' }">
            <i class="fa fa-dashboard"></i> Dashboard
          </router-link>
        </li>
        <li class="breadcrumb-item active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-12">
		  <div class="box box-body h-p100">
              <router-link :to="{ name: 'Compose' }" class="btn btn-success btn-block btn-shadow margin-bottom p-15">Compose</router-link>
			  <div class="box no-shadow">
				<div class="box-body no-padding mailbox-nav">
				  <ul class="nav nav-pills flex-column">
					<li class="nav-item">
						<a class="nav-link" :class="{ 'active': active == 'inbox' }" @click.prevent="setComponent('inbox')" href="javascript:void(0)">
							<i class="ion ion-ios-email-outline"></i> Inbox
					  		<span class="label label-success pull-right">12</span>
						</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" :class="{ 'active': active == 'sent' }" @click.prevent="setComponent('sent')" href="javascript:void(0)">
							<i class="ion ion-paper-airplane"></i> Sent
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" :class="{ 'active': active == 'drafted' }" @click.prevent="setComponent('drafted')" href="javascript:void(0)">
							<i class="ion ion-email-unread"></i> Drafts
						</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" :class="{ 'active': active == 'starred' }" @click.prevent="setComponent('starred')" href="javascript:void(0)">
							<i class="ion ion-star"></i>  Starred 
							<span class="label label-warning pull-right">14</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" :class="{ 'active': active == 'trashed' }" @click.prevent="setComponent('trashed')" href="javascript:void(0)">
							<i class="ion ion-trash-a"></i> Trash
						</a>
					</li>
				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /. box -->
			  <div class="box no-shadow b-1">
				<div class="box-body no-padding mailbox-nav">
				  <ul class="nav nav-pills flex-column">
					<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li>
					<li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-circle-o text-light-blue"></i> Social</a></li>
				  </ul>
				</div>
			  </div>
		  </div>
        </div>
        <div class="col-lg-9 col-12">
			<component :is="activeComponent" @loading_start="start" @loading_end="end"></component>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import Inbox from './Inbox';
import Sent from './Sent';
import Star from './Star';
import Draft from './Draft';
import Trash from './Trash';

export default {
    components: {
		Inbox,
		Sent,
		Star,
		Draft,
		Trash
	},

	data() {
		return {
			loading: false,
			activeComponent: null,
			active: null
		};
	},

	beforeMount() {
    	this.setComponent("inbox");
  	},

	methods: {
		setComponent(value) {
			switch (value) {
				case "inbox":
					this.activeComponent = Inbox;
					this.active = 'inbox'
				break;

				case "sent":
					this.activeComponent = Sent;
					this.active = 'sent'
				break;

				case "starred":
					this.activeComponent = Star;
					this.active = 'starred'
				break;

				case "drafted":
					this.activeComponent = Draft;
					this.active = 'drafted'
				break;

				case "trashed":
					this.activeComponent = Trash;
					this.active = 'trashed'
				break;

				default:
					this.activeComponent = Inbox;
				break;
			}
		},

		start() {
			this.loading = true;
		},

		end() {
			this.loading = false;
		}
	}
}
</script>

<style>

</style>