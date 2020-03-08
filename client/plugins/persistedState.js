import cookies from 'js-cookie';
import createPersistedState from 'vuex-persistedstate'
import cookie from 'cookie'

export default ({store, req, isDev}) => {
	console.log('PERSIST_STATE');

	createPersistedState({
	    storage: {
	    	getItem: key => cookies.get(key),
	    	setItem: (key, value) => cookies.set(key, value, { expires: 1, secure: !isDev }),
	    	removeItem: key => cookies.remove(key),
	    },
	})(store);
}		