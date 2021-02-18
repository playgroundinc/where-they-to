<template>
    <div class="row" v-if="type  === 'events'">
        <DateFilters 
            :date="date"
            v-on:update="updateValue"
        />
        <Accessibility 
            :value="accessibility"
            v-on:update="updateValue"
        />
        <VenueFilters 
            :errors="errors"
            :venue="venue"
            :province="province"
            :timezone="timezone"
            :city="city"
            v-on:update="updateValue"
        />
        <FamilyFilters 
            :errors="errors"
            :family="family"
            v-on:update="updateValue"
        />
        
    </div>
</template>

<script>
import Location from "../core/Location.js";

import Accessibility from "../components/Accessibility";
import Autocomplete from "../components/Autocomplete";
import Input from "../components/Input";

// Filters
import VenueFilters from "../components/filters/VenueFilters";
import DateFilters from "../components/filters/DateFilters";
import FamilyFilters from "../components/filters/FamilyFilters";

export default {
    props: {
        type: {
            type: String,
            required: true,
            default: 'events',
        },
        accessibility: {
            type: Array,
            required: false,
            default: [],    
        },
        errors: {
            type: Array,
            required: false,
            default: () => { return []},
        },
        venue: {
            type: String,
            required: false,
            default: '',
        },
        province: {
            type: String,
            required: false,
            default: '',
        },
        timezone: {
            type: String,
            required: false,
            default: '',
        },
        city: {
            type: String,
            required: false,
            default: '',
        },
        date: {
            type: String,
            required: false,
        },
        family: {
            type: String, 
            required: false,
            default: '',
        }
    },
    data() {
        return {
        
        }
	}, 
	components: {
		Accessibility,
        Autocomplete,
        Input,
        DateFilters,
        FamilyFilters,
        VenueFilters,
	},
	mounted() {
	},
    methods: {
        updateValue: function(updateObject) {
            this.$emit('update', updateObject);
        }
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
    }
};
</script>
