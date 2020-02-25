<template>
<div class="container mt-5">
    <b-form @submit.prevent="login">
      <b-form-group
        id="input-group-1"
        label="Email address:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.email"
          type="email"
          required
          placeholder="Enter email"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Password:" label-for="input-3">
        <b-form-input
          id="input-3"
          type="password"
          v-model="form.password"
          required
          placeholder="Enter password"
        ></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
    </b-form>	
</div>
</template>

<script>
export default {
	middleware: 'guest',
	layout: 'basic',

	data() {
		return {
			form: {
				email: '',
			}
		};
	},

	methods: {
		login() {
			this.$axios.post('login', this.form)
	        .then((resp) => {
	            this.$store.dispatch('setToken', {
	            	access_token: resp.data.access_token,
	            	expires_in: resp.data.expires_in
	            });
				this.$router.push({name: 'index'});
			})
	        .catch(errors => {
	            console.dir(errors);
	        });
		}
	}
}
</script>