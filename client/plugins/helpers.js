export default ({app}, inject) => {
	let status_variants = {
		pending: 'warning',
		processing: 'primary',
		succeeded: 'success',
	};

	inject('statusVariant', (status) => {
		return status_variants[status];
	})
}