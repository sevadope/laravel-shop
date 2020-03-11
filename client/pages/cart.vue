<template>
<div class="">
	<h1>
		{{ `Your cart(${cart.size} items):` }} 
		<span class="price">{{ cart.total_price }}</span>
	</h1>

	<b-table :items="cart.items" 
	:fields="fields">
		<template v-slot:cell(product)="data">
			<h4 class="">{{ data.item.product.name }}</h4>
			<img :src="data.item.product.image" :alt="data.item.product.name" 
			class="product-img-sm">
		</template>

		<template v-slot:cell(options)="data"> 
			<ul>
				<li v-for="(opt_value, opt_name) in data.item.options">
					{{ `${opt_name}: ${opt_value}` }}
				</li>
			</ul>
		</template>

		<template v-slot:cell(remove)="data">
			<b-button @click="removeItem(data.item.product.id, data.index)" 
			pill variant="outline-secondary">
				Remove
			</b-button>
		</template>
	</b-table>

	<div class="cart-actions">
		<b-button @click="goBack" variant="primary">Continue Shopping</b-button>
	</div>
</div>
</template>

<script>
export default {
	layout: 'basic',
	middleware: 'authed',

	data() {
		return {
			fields: [
				'product',
				'options',
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
