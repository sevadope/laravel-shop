<template>
<div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  	<nuxt-link class="navbar-brand" :to="{name:'index'}">
	  		Shop
	  	</nuxt-link>
	  	<nuxt-link class="navbar-brand" 
	  	v-if="isLoggedIn" :to="{name:'register'}">
	  		Sign Up
	  	</nuxt-link>
	  	<a v-else class="navbar-brand" href="#"> 
	  		You are logged in
	  	</a>

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