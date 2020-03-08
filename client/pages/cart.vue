<template>
<div class="">
	<h1>
		{{ `Your cart(${cart.size} items):` }} 
		<span class="price">{{ cart.total_price }}</span>
	</h1>

	<b-table :items="cart.items" 
	:fields="['product',  'options', 'count', 'total_price']">
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
	</b-table>

	<div class="cart-actions">
		<b-button @click="goBack" variant="primary">Continue Shopping</b-button>
	</div>
</div>
</template>

<script>
export default {
	layout: 'basic',
	middleware: 'auth',

	data() {
		return {
			cart: {},
		}
	},

	mounted() {
		this.$axiosAuthPost('cart', {})
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
		}
	},
}
</script>
