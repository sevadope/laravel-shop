export default ({app}, inject) => {
	let status_variants = {
		succeeded: 'success',
		pending: 'warning',
	};

	inject('statusVariant', (status) => {
		console.log(status_variants[status])
		return status_variants[status];
	})
}