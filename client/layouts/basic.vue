<template>
<div>
	<b-navbar type="dark" variant="dark">
		<b-navbar-brand :to="{name:'index'}">
			<h3>Shop</h3>
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>

			<b-navbar-nav class="ml-auto" v-show="isLoggedIn">
				<b-nav-item :to="{name: 'cart'}">
					<h5>Cart</h5>
				</b-nav-item>
				<b-nav-item :to="{name: 'orders'}">
					<h5>Orders</h5>
				</b-nav-item>
				<b-nav-item @click="logout" href="#">
					<h5>Logout</h5>
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
	<b-container class="main" fluid>
		<nuxt />	
	</b-container>
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
		content: ' ₽';
	}

	.cart-actions {
		display:flex;
		flex-direction: row;
		justify-content: center;
	}
</style>