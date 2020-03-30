<template>
	<b-container class="main">
		<b-row>
			<b-col cols="12" class="main-content">
				<h1 class="m-3">Orders:</h1>
				<b-table :items="orders" :fields="fields">
					<template v-slot:cell(total_price)="data">
						<span class="price">{{ data.item.total_price }}</span>
					</template>
					<template v-slot:cell(status)="data">					
						<b-badge pill :variant="$statusVariant(data.item.status)">{{ data.item.status }}
						</b-badge>
					</template>
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