<template>
<div class="form-group row">
    <div class="col-xxs-12">
        <h2 class="copy--center">Location</h2>
        <p class="copy--center">This site is only currently set up to support Canadian locations or online events.</p>
    </div>
    <div class="col-md-6"> 
        <Input
            name="province"
            :value="province"
            type="select"
            :options="provinces"
            :required="true"
            :errors="errors"
            v-on:update="updateValue"
        />
    </div>
    <div class="col-md-6" v-if="'' !== province">
        <Autocomplete 
			v-if="'' === city"
			:errors="errors"
			label="City"
			route="cities"
			:additionalRoute="province"
			:currentValue="city"
			v-on:selection="updateCity"
			v-on:new="createCity"
            newBtn="Add City"
        />
		<Input 
			v-else
			name="city"
			:value="city"
			type="text"
			:required="true"
			:errors="errors"
			:disabled="true"
			:clearButton="true"
			v-on:update="updateValue"
		/>
    </div>
</div>
</template>
<script>
// Components
import Input from '../components/Input';
import Autocomplete from '../components/Autocomplete';

// Classes
import Location from "../core/Location";

export default {
    props: {
        province: {
            type: String,
            required: true,
        },
        city: {
            type: String,
            required: true,
        },
        errors: {
            type: Array,
            required: true,
        },
    },
    components: {
        Autocomplete,
        Input,
    },
    computed: {
        location() {
            return new Location();
        },
        provinces() {
            const allProvinces = this.location.getProvinces();
            allProvinces.shift();
            return allProvinces;
        },
    },
    methods: {
        updateValue: function(updateObject) {
			if (updateObject.name === 'province') {
				this.$emit("update", { name: 'city', value: ''});
			}
            this.$emit("update", updateObject);
        },
        handleClick: function() {
			this.$emit("buttonClick");
		},
		updateCity: function(selection) {
			const updateObject = {
				name: 'city',
				value: selection.name,
			}
			this.updateValue(updateObject);
		},
		createCity: async function(newCity) {
			const data = {
                name: newCity,
            }
            const payload = {
                route: `${this.province}/cities`,
                data,
            }
			await this.$store.dispatch('create', payload);
			this.updateValue({ 
				name: 'city',
				value: newCity,
			});
		}
    }
}
</script>