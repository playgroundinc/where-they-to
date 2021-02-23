<template>
    <div class="row">
        <div class="col-xs-12">
            <Input 
                v-if="family !== ''"
                :value="family"
                name="family"
                type="text"
                :disabled="true"
                :clearButton="true"
                v-on:update="updateValue"
            />
            <Autocomplete 
                v-else
                :errors="errors"
                label="family"
                route="families"
                name="family"
                v-on:selection="updateFamily"
            />
        </div>
    </div>
</template>

<script>
import Autocomplete from "../../components/Autocomplete";
import Input from "../../components/Input";

export default {
    props: {
        errors: {
            type: Array,
            required: false,
            default: () => { return []},
        },
        family: {
            type: String,
            required: true,
            default: '',
        }
    },
	components: {
        Autocomplete,
        Input,
	},
    methods: {
        updateFamily: function(family) {
            this.$emit('update', {name: 'family', value: family.name });
        },
        updateValue: function(updateObject) {
            this.$emit('update', updateObject);
        },
        
    },

};
</script>
