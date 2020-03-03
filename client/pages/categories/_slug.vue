<template>
<div>
	<b-container class="main">
	  	<b-breadcrumb>
	  		<b-breadcrumb-item :to="{name: 'index'}" id="home-breadcrumb">
	  			Home
	  		</b-breadcrumb-item>
	  		<b-breadcrumb-item 
	  		v-for="ancestor in category.ancestors"
	  		:to="{name: 'categories-slug', params: {slug: ancestor.slug}}"
	  		:key="ancestor.slug">
	  			{{ ancestor.name }}
	  		</b-breadcrumb-item>
	  	</b-breadcrumb>
		<b-row>
			<b-col class="left-sidebar">
				<b-nav vertical>
					<b-nav-item v-for="child in category.children"
					:to="{name: 'categories-slug', params: {slug: child.slug}}">
						{{ child.name }}
					</b-nav-item>
				</b-nav>

			</b-col>

			<b-col cols="10" class="main-content">

				<b-card
				:title="category.name">
					<b-card-text>
						{{ category.description }}
					</b-card-text>
				</b-card>

				<div class="">
					<div class="group-item" v-for="product in category.products">
						<a href="#">
							<img class="product-image-sm" :src="product.image" :alt="product.name">
							<div class="">{{ product.name }}</div>
						</a>
					</div>
				</div>

			</b-col>
		</b-row>
	</b-container>
</div>
</template>

<script>
export default {
	layout: 'basic',

	data() {
		return {
			category_key: this.$route.params.slug,
			category: {},
		}
	},

	mounted() {
		console.log(this.category_key);

		this.$axios.post(`categories/${this.category_key}`)
		.then(resp => {
			this.category = resp.data.data;
		});

		console.log(this.category);
	}
}	
</script>

<style lang="scss">
.product-image-sm {
	border: 2px solid #343a40;
	border-radius: 10%;
	width: 10rem;
	height: 10rem;
}	
</style>
