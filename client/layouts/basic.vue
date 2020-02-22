<template>
<div>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  	<nuxt-link class="navbar-brand" :to="{name:'index'}">
	  		Shop
	  	</nuxt-link>

	</nav>
	<nuxt />
</div>
</template>
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