<template>
<div class="container mt-5">
    <b-form @submit.prevent="register">
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

      <b-form-group id="input-group-2" label="Your First Name:" label-for="input-2">
        <b-form-input
          id="input-2"
          v-model="form.first_name"
          required
          placeholder="Enter first name"
        ></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-4" label="Your Last Name:" label-for="input-4">
        <b-form-input
          id="input-4"
          v-model="form.last_name"
          required
          placeholder="Enter last name"
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
	// middleware: 'guest',
	layout: 'basic',

	data() {
		return {
			form: {
				first_name: '',
				last_name: '',
				email: '',
			}
		};
	},

	methods: {
		register() {
			this.$axios.post('register', this.form)
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