<template>
	<div class="">
			<div v-for="option in options">
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

			<div class="form-group row">
				<label for="products_count">Count: </label>
				<div class="">
					<input type="number" name="products_count" id="products_count"
					class="form-control" min="1" max="50"	
					v-model="products_count">					
				</div>
			</div>
			
			<button class="btn btn-warning btn-block" @click="sendForm">Add to cart</button>
	</div>	
</template>
<script>
	export default {
		props: [
			'form_action',
			'options',
			'product_key',
			'auth',
		],
		data: function () {
			return {
				opt_values: {},
				products_count: 1,
			};
		},

		created: function () {
			for (let key in this.options) {
				Vue.set(this.opt_values, this.options[key].name, this.options[key].values[0].value);
			}
		},

		methods: {
			toggleValue: function (opt_name, value) {
				this.opt_values[opt_name] = value;
			},

			sendForm: function () {
				if (this.auth) {
					axios.post(
						this.form_action, 
						{
							product_key: this.product_key,
							options: this.opt_values, 
							products_count: this.products_count,
						}
					);					
				} else {
					window.location.href = "/login";
				};

			},
		}
	}
</script>