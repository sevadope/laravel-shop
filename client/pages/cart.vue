<template>
	<b-row class="m-3">
		<b-col cols="12">
			<h1>
				{{ `Your cart(${cart.size} items):` }}
				<span class="price">{{ cart.total_price }}</span>
			</h1>

			<b-table :items="cart.items"
			:fields="fields">

				<template v-slot:cell(image)="data">
					<img :src="$storageUrl(data.item.product.image)"
					:alt="data.item.product.name"
					class="img-md">
				</template>

				<template v-slot:cell(name)="data">
					<h3>{{ data.item.product.name }}</h3>
						<b-button pill variant="outline-secondary" disabled
						v-for="(opt_value, opt_name) in data.item.options">
							{{ `${opt_name}: ${opt_value}` }}
						</b-button>
				</template>

				<template v-slot:cell(total_price)="data">
					<div class="price">{{ data.item.total_price }}</div>
				</template>

				<template v-slot:cell(remove)="data">
					<b-button pill variant="outline-secondary"
					@click="removeItem(data.item.product.id, data.index)">
						Remove
					</b-button>
				</template>

			</b-table>

			<div class="cart-actions">
				<b-button @click="goBack" variant="primary">Continue Shopping</b-button>
				<b-button :to="{name: 'payment-init'}" variant="warning">Make payment</b-button>
			</div>
		</b-col>
	</b-row>
</template>

<script>
export default {
	layout: 'basic',
	middleware: 'authed',

	data() {
		return {
			fields: [
				{key: 'image', label: ''},
				'name',
				'count',
				'total_price',
				{key: 'remove', label: ''},
			],

			cart: {},
		}
	},

	mounted() {
		this.$axiosAuthPost('cart')
		.then(resp => {
			this.cart = resp.data.data;
		})
		.catch(errors => {
			console.log(errors);
		})
	},

	methods: {
		goBack() {
			this.$router.go(-1);
		},

		removeItem(key, index) {
			this.$axiosAuthPost(`cart/remove`, {
				product_key: key,
			})
			.then(resp => {
				if (resp.status === 200) {
					this.cart.items.splice(index, 1);
				};
			})
			.catch(errors => {
				console.log(errors);
			});
		}
	},
}
</script>
