<template>
	<div class="">
		<b-row class="mt-5">
			<b-col cols="12">
				<h1>Your order:</h1>

				<b-table :items="cart.items" 
				:fields="cart_fields">
					<template v-slot:cell(image)="data">	
						<img :src="$storageUrl(data.item.product.image)" :alt="data.item.product.name" 
						class="img-md">
					</template>

					<template v-slot:cell(name)="data"> 
						<h3>{{ data.item.product.name }}</h3>
							<b-button pill variant="outline-secondary" disabled
							v-for="(opt_value, opt_name) in data.item.options">
								{{ `${opt_name}: ${opt_value}` }}
							</b-button>
					</template>

					<template v-slot:cell(price)="data"> 
						<div class="price">{{ data.item.product.price }}</div>
					</template>


					<template v-slot:cell(total_price)="data"> 
						<div class="price">{{ data.item.total_price }}</div>
					</template>

					<template v-slot:cell(remove)="data">
						<b-button @click="removeItem(data.item.product.id, data.index)" 
						pill variant="outline-secondary">
							Remove
						</b-button>
					</template>
				</b-table>	
				<h1>
					Total Price: 
					<span class="price">
						{{ cart.total_price }}
					</span>
				</h1>			
			</b-col>
		</b-row>
		<b-row class="m-5">
			<b-col cols="12">
				<div>
					<h1 class="">Select payment type</h1>
					<b-button-group block size="lg"
					class="d-flex">
				    	<b-button block	variant="warning"
				    	@click="initPayment('YandexCheckout')">
				    		Yandex.Checkout
				    	</b-button>
						<div></div>
				    	<b-button block	variant="secondary"
				    	@click="initPayment('Mock')">
				    		Mock
				    	</b-button>
						<div></div>
				    	<b-button block	variant="danger"
				    	@click="initPayment('WidgetMock')">
				    		Widget Mock
				    	</b-button>
					</b-button-group>
						<component v-bind:is="current_form"></component>
				</div>
			</b-col>
		</b-row>
	</div>
</template>

<script>
import Mock from '~/components/payment_forms/Mock.vue';
import WidgetMock from '~/components/payment_forms/WidgetMock.vue';
import YandexCheckout from '~/components/payment_forms/YandexCheckout.vue';

export default {
	layout: 'basic',
	middleware: 'authed',

	components: {
		Mock,
		WidgetMock,
		YandexCheckout,
	},

	data() {
		return {
			current_form: undefined,

			cart: {},

			cart_fields: [
				{key: 'image', label: ''},
				'name',
				'price',
				'count',
				'total_price',
				{key: 'remove', label: ''},	
			],
		};
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
		initPayment(client) {
			this.current_form = client;
		},

		removeItem(key, index) {
			$axiosAuthPost(`cart/remove`, {
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
		},
	},
}
</script>

<style lang="scss">
</style>