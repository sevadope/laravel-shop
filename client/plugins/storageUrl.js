export default ({app}, inject) => {
	inject('storageUrl', (url) => {
		return '/storage/' + url;
	});
}