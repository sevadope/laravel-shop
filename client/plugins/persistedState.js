import cookies from 'js-cookie';

import createPersistedState from 'vuex-persistedstate'

export default ({store}) => {
  window.onNuxtReady(() => {
    createPersistedState({
    	access_token: cookies.get('x-access-token'),
    })(store)
  })
}		