
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
  import { mapState } from 'vuex';

export default {

    data() {
      return {
      }
    },
    computed: mapState(['venues', 'user']),
  }
</script>