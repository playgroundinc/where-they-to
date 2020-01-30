<template>
  <div>
    <h1>Home</h1>
    <h2>Performers</h2>
    <ul>
      <li v-for="performer in performers" v-bind:key="performer.id">
        <a :href="'performers/' + performer.id"> {{ performer.name }}</a>
      </li>
    </ul>
    <h2>Events</h2>
    <ul>
      <li v-for="event in events" v-bind:key="event.id">
        <a :href="'events/' + event.id"> {{ event.name }}</a>
      </li>
    </ul>
    <h2>Venues</h2>
    <ul>
      <li v-for="venue in venues" v-bind:key="venue.id">
        <a :href="'venues/' + venue.id"> {{ venue.name }}</a>
      </li>
    </ul>
    <h2>Families</h2>
    <ul>
      <li v-for="family in families" v-bind:key="family.id">
        <a :href="'families/' + family.id"> {{ family.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapState } from 'vuex'
  export default {
    data() {
      return {
      }
    },
    computed: {
      ...mapState(['performers', 'events', 'families', 'venues', 'user'])
    },
    methods: {
  
    },
    created() {
      // this._getData('performers');
      // this._getData('events');
      // this._getData('venues');
      // this._getData('families');
    }
  }
</script>