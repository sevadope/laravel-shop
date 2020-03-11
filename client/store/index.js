import cookies from 'js-cookie';
import cookie from 'cookie';

export const state = () => ({
});

export const mutations = {
	SET_AUTH(state, auth) {
		state.auth = auth;
	},
};

export const actions = {
	async nuxtServerInit({ commit }, { app, req }) {
		let c = cookie.parse(req.headers.cookie);

		if (c['vuex'] !== undefined) {
			let auth = JSON.parse(c['vuex']).auth;
			commit('SET_AUTH', auth);
		};
	},

};
