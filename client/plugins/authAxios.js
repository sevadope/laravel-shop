export default ({app}, inject) => {
	inject('axiosAuthPost', (url, data = {}) => {

		app.$axios.setToken(app.$auth.getToken('local'));
		return app.$axios.post(url, data);
	});
}