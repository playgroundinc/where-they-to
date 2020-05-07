<template>
    <div>
        <label class="label" for="country">Country</label>
        <select
            class="input"
            name="country"
            v-model="country"
            @change.prevent="fetchLocations('country', 'states', 'country')"
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
                v-model="state"
                @change.prevent="
                    fetchLocations(
                        `country=${country}&state`,
                        'cities',
                        'state'
                    )
                "
            >
                <option v-if="states.length > 0" value=""
                    >Select Province/Region</option
                >
                <option v-else value="">Loading...</option>
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
                v-model="city"
                @change="passToParent('city')"
            >
                <option v-if="cities.length > 0" value="">Select City</option>
                <option v-else value="">Loading...</option>
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
            country: "",
            state: "",
            city: ""
        };
    },
    methods: {
        passToParent: function(ref) {
            this.$emit("changed", {
                key: ref,
                value: this[ref]
            });
        },
        handleCities: function(citiesBlock) {
            const location = [];
            for (let city in citiesBlock) {
                if (citiesBlock[city].city_name) {
                    location.push(citiesBlock[city].city_name);
                }
            }
            this.cities = location;
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
                const location = [];
                if (
                    resp.data &&
                    resp.data &&
                    resp.data.details &&
                    resp.data.details.regionalBlocs
                ) {
                    this.handleRegions(resp.data.details.regionalBlocs);
                    return;
                }
                if (resp.data) {
                    this.handleCities(resp.data);
                }
            } catch (err) {
                console.log(err);
            }
        },
        fetchLocations: async function(route, result, ref) {
            if (ref === "country") {
                this.state = "";
                this.states = [];
            }
            this.city = "";
            this.cities = [];
            let data = {
                name: result
            };
            try {
                data = {
                    route,
                    value: this[ref],
                    result
                };
                this.callLocationsApi(data);
                this.passToParent(ref);
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
