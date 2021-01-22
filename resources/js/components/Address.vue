<template>
<div class="form-group row">
    <div class="col-xxs-12">
        <h2 class="copy--center">Address</h2>
        <p class="copy--center">This site is only currently set up to support Canadian addresses or web addresses. If you're creating a profile for a digital platform, make the address the web address and set the province to Online. Rather than a city, we ask that you provide the timezone.</p>
        <p class="copy--center">{{ helperText }} <a v-if="buttonText" href="#" @click.prevent="handleClick">{{ buttonText }}</a></p>
        <Input
            name="address"
            :value="address"
            type="text"
            :required="true"
            :errors="errors"
            v-on:update="updateValue"
        />
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
    <div class="col-md-6">
        <Input 
            v-if="'OE' === province"
            name="timezone"
            :value="timezone"
            type="select"
            :required="true"
            :errors="errors"
            :options="timezones"
            v-on:update="updateValue"            
        />
        <Autocomplete 
			v-else-if="'' === city"
			:errors="errors"
			label="City"
			route="cities"
			:additionalRoute="province"
			:currentValue="city"
			v-on:selection="updateCity"
			v-on:new="createCity"
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
import Location from "../Location";

export default {
    props: {
        address: {
            type: String,
            required: true,
        },
        buttonText: {
			type: String,
			required: false,
        },
        helperText: {
			type: String,
			required: false,
        },
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
        timezone: {
            type: String,
            required: true,
        }
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
            return this.location.getProvinces();
        },
        timezones() {
            return this.location.getTimezones();
        }
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