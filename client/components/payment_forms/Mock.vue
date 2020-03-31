<template>
	<b-form @submit.prevent="submitForm" method="post" class="mt-3">
      <b-form-group
        id="field-group"
        label="Field:"
        label-for="field"
      >
        <b-form-input
          id="field"
          name="field"	
          type="text"
          required
          placeholder="Enter something"
          v-model="field"
        ></b-form-input>

        <b-button size="lg" class="mt-3" variant="primary" type="submit">
        	Pay for the order
    	</b-button>
      </b-form-group>		
	</b-form>
</template>

<script>
export default {
	data() {
		return {
			field: undefined,
		};
	},

	methods: {
		async submitForm() {
			let resp = await this.$axiosAuthPost(
        'payment/mock/store', 
        {field: this.field}
      );

      this.$router.push({name: 'orders'});
		}
	},
}
</script>

<style lang="scss">
	
</style>