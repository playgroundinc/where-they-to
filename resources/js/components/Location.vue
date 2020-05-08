<template>
    <div>
        <label class="label" for="country">Country</label>
        <select
            class="input"
            name="country"
            v-model="selectedCountry"
        >
            <option value="">Select Country</option>
            <option
                v-for="(country, index) in countries"
                :value="country"
                v-bind:key="index"
                >{{ country }}</option
            >
        </select>
        <div v-if="country">
            <label class="label" for="region">Province/Region</label>
            <select
                class="input"
                id="region"
                name="region"
                v-model="selectedState"
            >   
                <option v-if="states.length > 0" value="" disabled selected>Select Province/Region</option> 
                <option v-else value="" disabled selected>Loading...</option> 
                <option
                    v-for="(state, index) in states"
                    :value="state"
                    v-bind:key="index"
                    >{{ state }}</option
                >
                
                
            </select>
        </div>
        <div v-if="state">
            <label class="label" for="city">City</label>
            <select
                class="input"
                name="city"
                v-model="selectedCity"
            >
                <option v-if="cities.length > 0" value="" disabed selected>Select City</option>
                <option v-else value="" disabed selected>Loading...</option>
                <option
                    v-for="(city, index) in cities"
                    :value="city"
                    v-bind:key="index"
                    >{{ city }}</option
                >

            </select>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import countries from "../components/Countries.json";

export default {
    data() {
        return {
            countries: countries,
            states: [],
            cities: [],
            running: false,
        };
    },
    props: ['city', 'country', 'state'],
    computed: {
        selectedCity: {
            get: function () {
                return this.city;
            },
            set: function(newCity) {
                this.passToParent('city', newCity);
                return;
            }
        },
        selectedState: {
            get: function () {
                this.fetchLocations(`country=${this.country}&state`, 'cities', 'state');  
                return this.state;
            },
            set: function(newState) {
                this.clearValue("city");
                this.passToParent('state', newState);
                return;
            }
        },
        selectedCountry: {
            get: function () {
                this.fetchLocations('country', 'states', 'country')
                return this.country;
            },
            set: function(newCountry) {
                this.passToParent("country", newCountry);
                this.clearValue("state");
                this.clearValue("city");
                return 
            }
        }
    },
    created() {
        if (this.country !== '' && !this.states.length > 0 && this.state !== '' && !this.cities.length > 0 && this.city !== '') {
            return;
        } 
    },
    methods: {
        clearValue: function(ref) {
            this.$emit("changed", {
                key: ref,
                value: "",
            })  
        },
        passToParent: function(ref, value) {
            this.$emit("changed", {
                key: ref,
                value
            });
        },
        handleCities: function(citiesBlock) {
            const location = [];
            for (let city in citiesBlock) {
                if (citiesBlock[city].city_name) {
                    location.push(citiesBlock[city].city_name);
                }
            }
            return this.cities = location;
        },
        handleRegions: function(regionBlocks) {
            const location = [];
            regionBlocks.forEach(region => {
                location.push(region.state_name);
            });
            this.states = location;
        },
        callLocationsApi: async function(payload) {
            try {
                const resp = await axios.get(
                    `https://cors-anywhere.herokuapp.com/https://geodata.solutions/restapi?${payload.route}=${payload.value}`
                );
                if (
                    resp.data &&
                    resp.data.details &&
                    resp.data.details.regionalBlocs
                ) {
                    this.handleRegions(resp.data.details.regionalBlocs);
                    return;
                }
                if (resp.data) {
                    return this.handleCities(resp.data);
                }
            } catch (err) {
                console.log(err);
            }
        },
        fetchLocations: function(route, result, ref) {
            if (ref === "country") {
                this.states = [];
            } 
            if (ref === 'state' || ref === 'country') {
                this.cities = [];
            }
            try {
                const data = {
                    route,
                    value: this[ref],
                    result
                };
                this.callLocationsApi(data);
            } catch (e) {
                console.log(e);
            }
        },
        fetchCities: function(event) {
            let data = {
                route: "state",
                value: event.target.value,
                result: "cities"
            };
            this.callLocationsApi(data);
        }
    }
};
</script>
