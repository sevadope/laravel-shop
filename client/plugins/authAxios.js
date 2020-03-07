export default ({app}, inject) => {
	console.log(app.store.state);

	inject('axiosAuthPost', (url, data = {}) => {
		let config = {
			headers: {
				'Accept': 'application/json',
				'Authorization': `Bearer ${app.store.state.access_token}`,
			}
		}

		return app.$axios.post(url, data, config);
	});
}