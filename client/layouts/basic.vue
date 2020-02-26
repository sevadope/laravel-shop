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
		  	<a class="navbar-brand" href="#"> 
		  		You are logged in
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
        return this.$store.state.access_token;
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