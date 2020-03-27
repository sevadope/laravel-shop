export default ({app}, inject) => {
	let widgets = {
		mock(data) {
			app.router.push({name: 'orders'});
		},

		yandex_checkout(data, form_id) {
			const checkout = new window.YandexCheckout({
				confirmation_token: data.confirmation_token, 
				return_url: `http://eshop.dev/order/${data.order_id}/status`, 
			    error_callback(error) {
			    	console.log(error);
			    }
			});

			checkout.render(form_id);
		},
	};

	inject('renderPaymentWidget', (name, data, form_id) => {
		widgets[name](data, form_id);
	})
}