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
  middleware: 'is_guest',
	layout: 'basic',

	data() {
		return {
			form: {
				email: '',
			}
		};
	},

	methods: {
		async login() {
      let resp = await this.$auth.loginWith('local', {data: this.form});
		}
	}
}
</script>