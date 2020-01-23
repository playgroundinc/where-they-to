<template>
  <div class="main">
    <h1>Venues</h1>
    <ul>
      <li v-for="venue in venues" v-bind:key="venue.id">
        <a :href="'venues/' + venue.id"> {{ venue.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    data() {
      return {
        venues: [],
      }
    },
    methods: {
      _getData(route) {
        axios.get(`/${route}`)
        .then(({data}) => {
          this[route] = data;
        })
      }
    },
    created() {
      this._getData('venues');
    }
  }
</script>