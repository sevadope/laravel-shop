<template>
<div>
	<b-container class="main">
		<b-row>
			<b-col class="left-sidebar">
				
			</b-col>
			<b-col cols="10" class="main-content">
				<div v-for="category in categories" class="group-item">
					<nuxt-link 
					:to="{name: 'categories-slug', params: {slug: category.slug}}">
						<img class="category-image"
						:src="category.image" :alt="category.name">
						</img>
							
						<div>{{ category.name }}</div>
					</nuxt-link>
				</div>
			</b-col>
		</b-row>
	</b-container>
</div>
</template>

<script>
export default {
	data() {
		return {
			categories: []
		}
	},

	layout: 'basic',

	mounted() {
		this.$axios.post('categories')
		.then(resp => {
			this.categories = resp.data.data;
		})
		.catch(errors => {
			console.log(errors);
		});	
	},

}
</script>

<style lang="scss">
	.group-item {
		display: inline-flex;
		justify-content: center;
		align-items: center;
		text-align: center;
		width: 12rem;
		height: 12rem;
		margin: 1.5rem 1rem;
	}

	.category-image {
		display: flex;			
		border: 2px solid #343a40;
		border-radius: 10%;
		width: 10rem;
		height: 10rem;
	}
</style>