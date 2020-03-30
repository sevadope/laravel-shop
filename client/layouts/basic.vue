<template>
<div>
	<b-navbar type="dark" variant="dark">
		<b-navbar-brand :to="{name:'index'}">
			Shop
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>

			<b-navbar-nav class="ml-auto" v-show="isLoggedIn">
				<b-nav-item :to="{name: 'cart'}">
					Cart
				</b-nav-item>
				<b-nav-item :to="{name: 'orders'}">
					Orders
				</b-nav-item>
				<b-nav-item @click="logout" href="#">
					Logout
				</b-nav-item>
			</b-navbar-nav>

			<b-navbar-nav class="ml-auto" v-show="!isLoggedIn">
				<b-nav-item :to="{name:'login'}">
					Login
				</b-nav-item>	
				<b-nav-item :to="{name:'register'}">
					Sign Up
				</b-nav-item>
			</b-navbar-nav>

		</b-collapse>
	</b-navbar>
	<nuxt />
</div>
</template>

<script>
export default {
	computed: {
      isLoggedIn() {
        return this.$auth.loggedIn;
      }	
	},

	methods: {
		logout() {
			this.$auth.logout();
		}
	},
}
</script>

<style lang="scss">
	$card-width: 10rem;
	$img-lg-width: 20rem;
	$status-succeeded: 'success';
	$status-pending: 'warning';

	.card-list-item {
		display: inline-flex;
		max-width: $card-width;
		text-align: center;
	}

	.card-list {
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
	}
	.img-md {
		max-width: $card-width;
		height: $card-width;
	}

	.img-lg {
		max-width: $img-lg-width;
		height: $img-lg-width;
	}

	.main {
		min-width: 100vw;
		min-height: 90vh;
	}

	.price {
		color: black;
		font-weight: bolder;
	}

	.price:after {
		content: ' RUB';
	}
</style>