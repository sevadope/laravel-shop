<template>
	<b-form @submit.prevent="submitForm" class="mt-3">
      	<b-form-group
        	id="w-field-group"
        	label="Field:"
        	label-for="field"
      	>
        	<b-form-input
          		id="w-field"
          		name="field"	
          		type="text"
          		required
          		placeholder="Enter something"
        	></b-form-input>

    	</b-form-group>		

     	<b-form-group
     	  id="w-s-field-group"
     	  label="Second field:"
     	  label-for="s-field"
     	>
        	<b-form-input
        	  id="w-s-field"
        	  name="s-field"	
        	  type="text"
        	  required
        	  placeholder="Enter something"
        	></b-form-input>

    	</b-form-group>		

    	<b-button size="lg" class="mt-3" variant="primary" type="submit">
    		Pay for the order
 		</b-button>

	</b-form>
</template>

<script>
export default {
    data() {
        return {
            data: {},
        };
    },

    async mounted() {
        this.data = await this.$axiosAuthPost(
            'payment/widgets/init',
            {name: 'widget_mock'}
        );
    },

    methods: {
        submitForm() {
            this.$router.push({name: 'orders'});
        },
    },
}
</script>

<style lang="scss">
	
</style>