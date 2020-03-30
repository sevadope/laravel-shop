<template>
<div>
	<b-container class="main">
		<b-row class="justify-content-center">
			<b-col cols="11" class="main-content">
				<div class="card-list">
					<div v-for="category in categories"
					  class="card-list-item m-3"
					> 
						<nuxt-link 
						:to="{name: 'categories-slug', params: {slug: category.slug}}">
						<img :src="$storageUrl(category.image)" alt=""
						class="card-img-top img-md">
						<div class="card-footer">
							{{ category.name }}
						</div>
							
						</nuxt-link>
					</div>
					
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

</style>