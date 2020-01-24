<template>
    <div class="card filter-box-form">
        <form @submit="onSubmit">
            <div class="card-body">
                    <div class="form-group row">

                        <label for="min_price">Min price:</label>
                        <input id='min_price' name="min_price"
                        type="text" class="form-control" 
                        v-model="form.min_price" 
                        :disabled="form.min_price === this.disable_value">
                        <div class="alert alert-danger"
                        v-if="this.errors.hasOwnProperty('min_price')">
                            {{ this.errors.min_price[0] }}
                        </div>

                        <label for="max_price">Max price:</label>
                        <input id='max_price' name="max_price" 
                        type="text" class="form-control" 
                        v-model="form.max_price" 
                        :disabled="form.max_price === this.disable_value">
                        <div class="alert alert-danger"
                        v-if="this.errors.hasOwnProperty('max_price')">
                            {{ this.errors.max_price[0] }}
                        </div>

                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button> 
            </div>            
        </form>
    </div>    
</template>

<script>
    export default {
        props: {
            errors: {
                type: Object,
                default: function () {return {}},
            },
        },

        data: function () {
            return {
                disable_value: undefined,

                form: {
                    min_price: null,
                    max_price: null,
                }
            }
        },

        methods: {
            onSubmit: function (e) {
                let empty_fields = Object.keys(this.form)
                    .filter(item => this.form[item] === null);

                for (let key in this.form) {
                    if (empty_fields.includes(key)) {
                        this.form[key] = this.disable_value;
                    }
                }
            },
        },
    }
</script>
