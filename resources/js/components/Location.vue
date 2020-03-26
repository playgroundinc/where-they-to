<template> 
  <div>
    <label class="label" for="country">Country</label>
    <select class="input" name="country" v-model="refCountry" @change.prevent="fetchLocations('country', 'states', 'refCountry')">
      <option value="">Select Country</option>
      <option v-for="(country, index) in countries" :value="country" v-bind:key="index">{{country}}</option>
    </select>
    <div v-if="states.length > 0">
      <label class="label" for="province">Province/Region</label>
      <select class="input" name="province" v-model="refState" @change.prevent="fetchLocations(`country=${refCountry}&state`, 'cities', 'refState')">
        <option value="">Select Province/Region</option>
        <option v-for="(state, index) in states" :value="state" v-bind:key="index">{{state}}</option>
      </select>
    </div>
    <div v-if="states.length && cities.length > 0">
      <label class="label" for="city">City</label>
      <select class="input" name="city" v-model="refCity">
        <option value="">Select City</option>
        <option v-for="(city, index) in cities" :value="city" v-bind:key="index">{{city}}</option>
      </select>
    </div>
  </div>
</template>

<script> 
import { mapState } from 'vuex';
import countries from '../components/Countries.json';

export default {
  data() {
    return {
      countries: countries,
      refCountry: '',
      refState: '',
      refCity: '',
    }
  },
  props: {
    country: {
      required: true,
    },
    province: {
      required: true,
    }, 
    city: {
      required: true,
    }
  },
  computed: {
    ...mapState(['states', 'cities'])
  },
  methods: {
    fetchLocations: async function(route, result, ref) {
      let data = {
        name: result,
      }
      try {
        await this.$store.dispatch('clearState', data);
        data = {
          route,
          value: this[ref],
          result
        }
        this.$store.dispatch('fetchLocation', data);
      } catch(e) {
        console.log(e);
      }
    },
    fetchCities: function(event) {
      let data = {
        route: 'state',
        value: event.target.value,
        result: 'cities',
      }
      this.$store.dispatch('fetchLocation', data);
    }
  }
}
</script>