<template>
  <div class="" id="payment-form">
    
  </div>
</template>

<script>
export default {

	data() {
		return {
			data: {},
		}
	},

	async mounted() {
	    this.data = await this.$axiosAuthPost(
	        'payment/widgets/init',
	        {name: 'mock_widget'}
	    );

		let widget_script = document.createElement('script');
		widget_script.setAttribute('src', 'https://kassa.yandex.ru/checkout-ui/v2.js');
		widget_script.async = true;
		document.head.appendChild(widget_script);

		const checkout = new window.YandexCheckout({
			confirmation_token: this.data.confirmation_token, 
			return_url: `http://eshop.dev/order/${this.data.payment_id}/status`, 
		    error_callback(error) {
		    	console.log(error);
		    }
		});
		
		checkout.render('payment-form');		
	},
}
</script>

<style lang="scss">
	
</style>