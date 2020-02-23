export default function ({store, redirect}) {
	if (!store.state.access_token) {
		return redirect('index');
	};
}