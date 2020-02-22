import cookies from 'js-cookie';

export const state = () => ({
  access_token: null,
});

export const mutations = {
  SET_TOKEN(state, access_token) {
    state.access_token = access_token;
  },

  REMOVE_TOKEN(state) {
    state.access_token = null;
  }
};

export const actions = {
  setToken({commit}, {access_token, expires_in}) {
    this.$axios.setToken(access_token, 'Bearer');
    const expiryTime = new Date(new Date().getTime() + expires_in * 1000);
    cookies.set('x-access-token', access_token, {expires: expiryTime});
    commit('SET_TOKEN', access_token);
  },

  async refreshToken({dispatch}) {
    const {access_token, expires_in} = await this.$axios.$post('refresh-token');
    dispatch('setToken', {access_token, expires_in});
  },

  logout({commit}) {
    this.$axios.setToken(false);
    cookies.remove('x-access-token');
    commit('REMOVE_TOKEN');
  }
};