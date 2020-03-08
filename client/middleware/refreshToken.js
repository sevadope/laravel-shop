import cookies from 'js-cookie';

export default function ({ app, store, redirect }) {

  const token = app.$auth.getToken('local');

  if (store.state.auth && store.state.auth.loggedIn && ! token) {
    console.log('TOKEN EXPIRED');
  }
}
