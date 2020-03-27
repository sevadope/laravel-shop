<template>
<div>
	<b-navbar type="dark" variant="dark">
		<b-navbar-brand :to="{name:'index'}">
			Shop
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

		<b-collapse id="nav-collapse" is-nav>

			<b-navbar-nav v-if="isLoggedIn">
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

			<b-navbar-nav v-else>
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
	.main {
		min-width: 100vw;
		min-height: 90vh;
		border: 5px dotted white;		
	}

	.left-sidebar {
		@extend .collumn;
	}

	.main-content {
		@extend .collumn;
	}

	.collumn {
		border: 3px dotted red;
	}
</style>