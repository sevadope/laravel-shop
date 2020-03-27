<template>
<div class="">
	<b-container class="main">
		<b-row class="m-5">
			<b-col cols="12">
				<div>
					<h3>Choose payment client:</h3>
				  	<b-button v-b-toggle.form variant="warning" 
				  	@click="initPayment('yandex_checkout')">
				  		Yandex.Kassa
				  	</b-button>
				  	<b-button v-b-toggle.form variant="primary" 
				  	@click="initPayment('mock')">
				  		Mock
				  	</b-button>
				  	<b-collapse id="form">
				     <div id="widget-form">
				     	
				     </div>  		
				  	</b-collapse>
				</div>
			</b-col>
		</b-row>
	</b-container>
</div>
</template>

<script>
export default {
	layout: 'basic',
	middleware: 'authed',

  	head() {
    	return {
      		script: [
        		{
        			hid: 'yandex_checkout', 
        			src: 'https://kassa.yandex.ru/checkout-ui/v2.js',

        		}	
      		]
    	};
	},

	methods: {
		async initPayment(client) {
			let resp = await this.$axiosAuthPost(
				'payment/init',
				{client: client}
			);

			this.$renderPaymentWidget(client, resp.data, 'widget-form');
		}
	}
}
</script>

<style lang="scss">
</style>