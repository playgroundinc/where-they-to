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
        <PerformerFilters 
            :errors="errors"
            :performers="performers"
            v-on:update="updateValue"
        />
        <TypeFilters 
            :errors="errors"
            :eventTypes="eventTypes"
            route="eventTypes"
            type="event"
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
import PerformerFilters from "../components/filters/PerformerFilters";
import TypeFilters from "../components/filters/TypeFilters";

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
        },
        performers: {
            type: Array,
            required: false,
            default: () => [],
        },
        eventTypes: {
            type: Array,
            required: false,
            default: () => [],
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
        PerformerFilters,
        TypeFilters,
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
