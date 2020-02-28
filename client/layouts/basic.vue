<template>
<div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  	<nuxt-link class="navbar-brand" :to="{name:'index'}">
	  		Shop
	  	</nuxt-link>
	  	<div v-if="!isLoggedIn">
		  	<nuxt-link class="navbar-brand" :to="{name:'login'}">
		  		Login
		  	</nuxt-link>		

		  	<nuxt-link class="navbar-brand" :to="{name:'register'}">
		  		Sign Up
		  	</nuxt-link>	
	  	</div>

		<div v-else>
		  	<a class="navbar-brand" href="#"  @click="logout"> 
		  		Logout	
		  	</a>			
		</div>

	</nav>
	<nuxt />
</div>
</template>

<script>
export default {
	computed: {
      isLoggedIn() {
        return this.$store.state.auth;
      }	
	},

	methods: {
		logout() {
			let config = {
				headers: {
					Authorization: `Bearer ${this.$store.state.access_token}`,
				}
			};
			this.$axios.post('logout', null, config)
			.then(resp => {
				this.$store.dispatch('logout');
				this.$router.push('/');
			})
			.catch(errors => {
				console.log(errors);
			});
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