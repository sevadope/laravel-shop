<template>
	<b-container class="main">
		<b-row>
			<b-col class="left-sidebar">
				
			</b-col>
			<b-col cols="10" class="main-content">
				<b-table :items="orders" :fields="fields">
					
				</b-table>
			</b-col>
		</b-row>
	</b-container>
</template>
<script>
export default {
	layout: 'basic',
	middleware: 'authed',

	data() {
		return {
			fields: [
				'id',
				'total_price',
				'status',
				'created_at',
			],
			orders: [],
		}
	},

	mounted() {
		this.$axiosAuthPost('orders')
		.then(resp => {
			this.orders = resp.data.data;
		})
		.catch(errors => {
			console.log(errors);
		})
	},
}
</script>

<style lang="scss">
</style>