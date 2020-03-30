<template>
<b-container class="mt-4" fluid>
	<b-row align-items="end">
		<b-col>
			<div class="m-3">
				<img class="product-img-lg" :src="$storageUrl(product.image)" :alt="product.name">
			</div>
		</b-col>
		<b-col>
			<div>
				<h3 class="product-title">{{ product.name }}</h3>
				<ul>
					<li v-for="spec in product.specifications" :key="spec.id">
						{{ spec.name + ': ' + spec.value }}
					</li>
				</ul>

				<div v-for="option in product.options">
					<h5 class="options-header">
						{{ option.name }}: {{opt_values[option.name]}}
					</h5>
					<div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
						<label class="btn btn-secondary"
						v-for="value in option.values">
							<input type="radio" name="options" 
							:id="value.value" :value="value.value"
							@click="toggleValue(option.name, value.value)">
							{{ value.value }}
						</label>							
					</div>
				</div>
			</div>
		</b-col>
		<b-col>
			<b-form-group
			label-cols-sm="4"
			label-cols-lg="2"
			:label="`Count: ${products_count}`"
			label-for="products_count">
				<b-form-input type="number" id="products_count"
				v-model="products_count"
				></b-form-input>
			</b-form-group>
			<div class="product-actions">
				<b-button @click="addToCart" variant="warning">Add to cart</b-button>
			</div>
		</b-col>
	</b-row>
</b-container>
</template>

<script>
export default {
	layout: 'basic',

	data() {
		return {
			product_key: this.$route.params.slug,
			product: {},
			products_count: 1,
			opt_values: {},
		}
	},

	mounted() {
		this.$axios.post(`products/${this.product_key}`)
		.then(resp => {
			this.product = resp.data.data;

			let options = this.product.options;
			for (let key in options) {
				this.$set(this.opt_values, options[key].name, options[key].values[0].value);
			}
		})
		.catch(errors => {
			console.log(errors);
		})
	},

	methods: {
		toggleValue(opt_name, value) {
			this.opt_values[opt_name] = value;
		},

		addToCart() {
			if (this.$auth.loggedIn) {
				this.$axiosAuthPost('cart/add', {
					options: this.opt_values,
					products_count: this.products_count,
					product_key: this.product.id,
				});
				this.$router.push({name: 'cart'});		
			} else {
				this.$router.push({name: 'login'});
			}
		},
	},
}
</script>

<style lang="scss">
.product-actions {
	display: flex;
	flex-direction: row;
	align-items: center;
	justify-content: center;
}

.product-img-lg {
	border: 2px solid gray;
	width: 25rem;
}

.product-title {
	font-weight: bolder;
}
</style>