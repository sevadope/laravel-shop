export default ({app}, inject) => {
	let status_variants = {
		succeeded: 'success',
		pending: 'warning',
	};

	inject('statusVariant', (status) => {
		return status_variants[status];
	})
}