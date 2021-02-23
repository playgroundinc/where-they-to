<template>
    <div class="row">
        <div class="col-xs-12">
            <Input 
                v-if="venue !== ''"
                :value="venue"
                name="venue"
                type="text"
                :disabled="true"
                :clearButton="true"
                v-on:update="updateVenue"
            />
            <Autocomplete 
                v-else
                :errors="errors"
                label="venue"
                route="venues"
                name="venue"
                v-on:selection="updateVenue"
            />
        </div>
        <div class="col-md-6">
            <Input 
                type="select"
                name="province"
                :value="province"
                :options="provinces"
                v-on:update="updateValue"
            />
        </div>
        <div class="col-md-6">
            <Input 
                v-if="province === 'OE'"
                type="select"
                name="timezone"
                :value="timezone"
                :options="timezones"
                v-on:update="updateValue"
            />
            <Input 
                v-else
                name="city"
                :value="city"
                type="select"
                :options="cities"
                :disabled="activeCities"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
        </div>
    </div>
</template>

<script>
import Location from "../../core/Location.js";

import Autocomplete from "../../components/Autocomplete";
import Input from "../../components/Input";

export default {
    props: {
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
        }
    },
    data() {
        return {
            cities: {},
        }
	}, 
	components: {
        Autocomplete,
        Input,
	},
	mounted() {
	},
    watch: {
        province: function(newProvince, oldProvince) {
            if (newProvince !== '') {
                this.getCities();
                return;
            }
            this.cities = {};
        }
    },
    methods: {
        getCities: async function() {
            this.updateValue({name: 'city', value: ''});
            const resp = await this.$store.dispatch('fetchState', { route: `${this.province}/cities`});
            if (resp.status === 200) {
                
                const cities = {};
                if (resp.data.length) {
                    resp.data.forEach(city => {
                        const key = city.name.replace(' ', '_');
                        cities[key] = city.name;
                    });
                } 
                this.cities = cities;
            }
        },
        updateVenue: function(venue) {
            if (venue.province) {
                this.$emit('update', { name: 'venue', value: venue.name })
                this.$emit('update', { name: 'province', value: venue.province});
                this.$emit('update', { name: 'timezone', value: venue.timezone });
                this.$emit('update', { name: 'city', value: venue.city });
                return;
            }
            this.$emit('update', { name: 'venue', value: '' })
            this.$emit('update', { name: 'province', value: ''});
            this.$emit('update', { name: 'timezone', value: '' });
        },
        updateValue: function(updateObject) {
            this.$emit('update', updateObject);
        },
        updateCity: function(selection) {
			const updateObject = {
				name: 'city',
				value: selection.name,
			}
			this.updateValue(updateObject);
		},
        getObjectSize: function(obj) {
            let size = 0;
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
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
        },
        activeCities() {
            const size = this.getObjectSize(this.cities);
            return size <= 0;
        }
    }
};
</script>
